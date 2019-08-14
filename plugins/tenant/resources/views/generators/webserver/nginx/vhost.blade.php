#
#   Auto generated Nginx configuration
#       @author: AnhPham
#       @time: {{ date('H:i:s d-m-Y') }}
#       @website id: {{ $tenant->id }}
#       @website db_name: {{ $tenant->db_name }}
#       @website host_name: {{ $tenant->host_name }}
#

@if(!empty($tenant))
    @include('plugins-tenant::generators.webserver.nginx.blocks.server', [
        'hostname' => $tenant,
        'media' => $media
    ])
@else
    #
    #   No hostnames found
    #
@endif
