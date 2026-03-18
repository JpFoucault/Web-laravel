@include('pages.user.partials.head')

<body>
    
    @include('pages.user.partials.header', ['active' => 'settings'])

    <div class="content_create">
        
        <div style="margin-bottom: 30px; border-bottom: 1px solid #334155; padding-bottom: 20px;">
            <a href="{{ route('settings') }}" style="color: #94a3b8; text-decoration: none; font-size: 14px; margin-bottom: 10px; display: inline-block;">&larr; Retour aux paramètres</a>
            <h1 style="color: #f8fafc; margin: 10px 0 0 0;">Modifier mon profil</h1>
        </div>

        <div style="display: flex; flex-direction: column; gap: 30px;">
            
            <div class="form-card">
                @include('profile.partials.update-profile-information-form')
            </div>

            <div class="form-card">
                @include('profile.partials.update-password-form')
            </div>

            <div class="form-card" style="border: 1px solid #ef4444;">
                @include('profile.partials.delete-user-form')
            </div>

        </div>

    </div>

</body>
</html>