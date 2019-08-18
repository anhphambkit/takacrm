#
#   Auto generated Nginx configuration
#       @author: hyn/multi-tenant
#       @see: http://laravel-tenancy.com
#       @time: {{ date('H:i:s d-m-Y') }}
#       @website db_name: {{ $tenant->db_name }}
#       @website host_name: {{ $tenant->host_name }}
#

@if($tenant->isNotEmpty())
    @include('plugins-tenant::generators.webserver.apache.blocks.server', [
        'hostname' => $tenant,
        'media' => $media
    ])
@else
    #
    #   No hostnames found
    #
@endif