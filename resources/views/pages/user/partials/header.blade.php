<header class="main-header">
    @php($active = $active ?? '')

    <div class="logo-container">
        <a href="{{ url('dashboard') }}"><img src="{{ asset('assets/FlowDesklogo.png') }}" alt="Logo FlowDesk" class="logo-img"></a>
    </div>

    <nav class="main-nav">
        <ul>
            <li><a href="{{ url('dashboard') }}" class="{{ $active === 'dashboard' ? 'active' : '' }}">Tableau de bord</a></li>
            <li><a href="{{ url('project') }}" class="{{ $active === 'project' ? 'active' : '' }}">Mes Projets</a></li>
            <li><a href="{{ url('tickets') }}" class="{{ $active === 'tickets' ? 'active' : '' }}">Tickets</a></li>
            <li><a href="{{ url('bills') }}" class="{{ $active === 'bills' ? 'active' : '' }}">Facturation</a></li>
            <li><a href="{{ url('documents') }}" class="{{ $active === 'documents' ? 'active' : '' }}">Documents</a></li>
            <li><a href="{{ url('contacts') }}" class="{{ $active === 'contacts' ? 'active' : '' }}">Contacts</a></li>
            <li><a href="{{ url('settings') }}" class="{{ $active === 'settings' ? 'active' : '' }}">Settings</a></li>
        </ul>
    </nav>

    <div class="user-profile">
        <span>{{ auth()->user()->name }}</span>
        <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
    </div>
</header>
