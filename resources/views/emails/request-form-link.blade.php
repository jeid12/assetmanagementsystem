@php
    $slug = $token->requestType->slug;
    $formRoute = match ($slug) {
        'maintenance' => '/rform',
        'new-device' => '/newdevice',
        'other' => '/rform', 
    };

    $formUrl = config('app.frontend_url') . $formRoute . '?token=' . $token->token;
@endphp

@component('mail::message')
# School Request Form Access

You requested a **{{ $token->requestType->name }}** for **{{ $token->school->name }}**.  

Click below to access the form (expires in **30 minutes**):  

@component('mail::button', ['url' => $formUrl])
Access Form
@endcomponent

**Need help?**  
Contact support at {{ config('app.support_email') }}.  

Thanks,  
{{ config('app.name') }}  
@endcomponent
