@component('mail::message')
# School Request Form Access

You requested a **{{ $token->requestType->name }}** for **{{ $token->school->name }}**.  

Click below to access the form (expires in **30 minutes**):  

@component('mail::button', ['url' => config('app.frontend_url') . 'rform?token=' . $token->token])
Access Form
@endcomponent

**Need help?**  
Contact support at {{ config('app.support_email') }}.  

Thanks,  
{{ config('app.name') }}  
@endcomponent