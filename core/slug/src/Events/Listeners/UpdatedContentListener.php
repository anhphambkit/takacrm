<?php

namespace Core\Slug\Events\Listeners;

use Core\Base\Events\UpdatedContentEvent;
use Core\Slug\Repositories\Interfaces\SlugRepositories as SlugInterface;
use Core\Slug\Services\SlugService;
use Exception;
use Illuminate\Support\Str;

class UpdatedContentListener
{

    /**
     * @var SlugInterface
     */
    protected $slugRepository;

    /**
     * SlugService constructor.
     * @param SlugInterface $slugRepository
     */
    public function __construct(SlugInterface $slugRepository)
    {
        $this->slugRepository = $slugRepository;
    }

    /**
     * Handle the event.
     *
     * @param UpdatedContentEvent $event
     * @return void
     * @author TrinhLe
     */
    public function handle(UpdatedContentEvent $event)
    {
        if (in_array($event->screen, config('core-slug.general.supported'))) {
            try {
                $slug = $event->request->input('slug', $event->data->slug ?? Str::slug($event->data->name . '-' . $event->data->id) ?? time());

                $item = $this->slugRepository->getFirstBy([
                    'reference'    => $event->screen,
                    'reference_id' => $event->data->id,
                ]);

                if ($item) {
                    $slugService = new SlugService(app(SlugInterface::class));
                    $item->key = $slugService->create($slug, $event->data->slug_id);
                    $item->prefix = config('core-slug.general.prefixes.' . $event->screen, '');
                    $this->slugRepository->createOrUpdate($item);
                } else {
                    $this->slugRepository->createOrUpdate([
                        'key'          => $slug,
                        'reference'    => $event->screen,
                        'reference_id' => $event->data->id,
                        'prefix'       => config('core-slug.general.prefixes.' . $event->screen, ''),
                    ]);
                }
            } catch (Exception $exception) {
                info($exception->getMessage());
            }
        }
    }
}
