<?php

/*
 * This file is part of the hyn/multi-tenant package.
 *
 * (c) Daniël Klabbers <daniel@klabbers.email>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @see https://laravel-tenancy.com
 * @see https://github.com/hyn/multi-tenant
 */

namespace Plugins\Tenancy\Middleware;

use Closure;
use Plugins\Tenancy\Contracts\CurrentHostname;
use Plugins\Tenancy\Contracts\Hostname;
use Plugins\Tenancy\Events\Hostnames\NoneFound;
use Plugins\Tenancy\Events\Hostnames\Redirected;
use Plugins\Tenancy\Events\Hostnames\Secured;
use Plugins\Tenancy\Events\Hostnames\UnderMaintenance;
use Plugins\Tenancy\Traits\DispatchesEvents;
use Illuminate\Foundation\Http\Exceptions\MaintenanceModeException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class HostnameActions
{
    use DispatchesEvents;

    /**
     * @var Redirector
     */
    protected $redirect;

    /**
     * @param Redirector $redirect
     */
    public function __construct(Redirector $redirect)
    {
        $this->redirect = $redirect;
    }

    /**
     * @param Request $request
     * @param Closure $next
     * @return RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $hostname = config('tenancy.hostname.auto-identification')
            ? app(CurrentHostname::class)
            : null;

        if ($hostname != null) {
            $this->setAppUrl($request, $hostname);

            if ($hostname->under_maintenance_since) {
                return $this->maintenance($hostname);
            }

            if ($hostname->redirect_to) {
                return $this->redirect($hostname);
            }

            if (!$request->secure() && $hostname->force_https) {
                return $this->secure($hostname, $request);
            }
        } else {
            $this->abort($request);
        }

        return $next($request);
    }

    /**
     * @param Hostname $hostname
     * @return RedirectResponse
     */
    protected function redirect(Hostname $hostname)
    {
        $this->emitEvent(new Redirected($hostname));

        return $this->redirect->away($hostname->redirect_to);
    }

    /**
     * @param Hostname $hostname
     * @param Request $request
     * @return RedirectResponse
     */
    protected function secure(Hostname $hostname, Request $request)
    {
        $this->emitEvent(new Secured($hostname));

        return $this->redirect->secure($request->path());
    }

    /**
     * @param Hostname $hostname
     */
    protected function maintenance(Hostname $hostname)
    {
        $this->emitEvent(new UnderMaintenance($hostname));
        throw new MaintenanceModeException($hostname->under_maintenance_since->timestamp);
    }

    /**
     * Aborts the application.
     * @param Request $request
     */
    protected function abort(Request $request)
    {
        if (config('tenancy.hostname.abort-without-identified-hostname')) {
            $this->emitEvent(new NoneFound($request));
            return abort(404);
        }
    }

    /**
     * Forces the app.url configuration to the tenant hostname domain.
     *
     * @param Request  $request
     * @param Hostname $hostname
     */
    protected function setAppUrl(Request $request, Hostname $hostname)
    {
        if (config('tenancy.hostname.update-app-url', false)) {
            config([
                'app.url' => sprintf('%s://%s', $request->getScheme(), $hostname->fqdn)
            ]);
        }
    }
}
