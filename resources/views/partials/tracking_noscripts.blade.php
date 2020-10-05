{{-- Google Tag Manager (noscript) --}}
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ config('services.google.tag_manager_id') }}{!! config('services.google.tag_manager_env') !!}" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
{{-- End Google Tag Manager (noscript) --}}

@if(app()->environment('production'))
{{-- Facebook Pixel (noscript) --}}
<noscript><img height="1" width="1" src="https://www.facebook.com/tr?id={{ config('services.facebook.tracking_pixel_id') }}&ev=PageView&noscript=1{{ $fb_purchase }}"/></noscript>
{{-- End Facebook Pixel (noscript) --}}
@endif
