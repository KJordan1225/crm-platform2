<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CRM Platform</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --crm-blue: #0d6efd;
            --crm-dark: #1f2937;
            --crm-light: #f8fafc;
            --crm-border: #e5e7eb;
        }

        body {
            background: var(--crm-light);
        }

        .crm-wrapper {
            min-height: 100vh;
            display: flex;
        }

        .crm-sidebar {
            width: 260px;
            background: var(--crm-dark);
            color: white;
            min-height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            padding: 1rem;
        }

        .crm-sidebar-brand {
            font-size: 1.4rem;
            font-weight: 800;
            margin-bottom: 2rem;
            color: white;
        }

        .crm-sidebar a {
            display: block;
            color: #d1d5db;
            text-decoration: none;
            padding: .75rem 1rem;
            border-radius: .5rem;
            margin-bottom: .35rem;
        }

        .crm-sidebar a:hover,
        .crm-sidebar a.active {
            background: var(--crm-blue);
            color: white;
        }

        .crm-main {
            margin-left: 260px;
            width: calc(100% - 260px);
            min-height: 100vh;
        }

        .crm-topbar {
            background: white;
            border-bottom: 1px solid var(--crm-border);
            padding: 1rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .crm-content {
            padding: 1.5rem;
        }

        .stat-card {
            border: 0;
            border-radius: 1rem;
            box-shadow: 0 10px 25px rgba(15, 23, 42, .08);
        }

        .stat-label {
            color: #6b7280;
            font-size: .9rem;
            text-transform: uppercase;
            letter-spacing: .04em;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 800;
        }

        .pipeline-stage {
            border-left: 5px solid var(--crm-blue);
        }

        @media(max-width: 768px) {
            .crm-sidebar {
                position: relative;
                width: 100%;
                min-height: auto;
            }

            .crm-wrapper {
                display: block;
            }

            .crm-main {
                margin-left: 0;
                width: 100%;
            }
        }
    </style>
</head>

<body>
<div class="crm-wrapper">
    <aside class="crm-sidebar">
        <div class="crm-sidebar-brand">
            CRM Platform
        </div>

        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
            Dashboard
        </a>

        <a href="{{ route('accounts.index') }}" class="{{ request()->routeIs('accounts.*') ? 'active' : '' }}">
            Accounts
        </a>

        <a href="{{ route('contacts.index') }}" class="{{ request()->routeIs('contacts.*') ? 'active' : '' }}">
            Contacts
        </a>

        <a href="{{ route('leads.index') }}" class="{{ request()->routeIs('leads.*') ? 'active' : '' }}">
            Leads
        </a>

        <a href="{{ route('opportunities.index') }}" class="{{ request()->routeIs('opportunities.*') ? 'active' : '' }}">
            Opportunities
        </a>

        <a href="{{ route('crm-tasks.index') }}" class="{{ request()->routeIs('crm-tasks.*') ? 'active' : '' }}">
            Tasks
        </a>

        <a href="{{ route('campaigns.index') }}" class="{{ request()->routeIs('campaigns.*') ? 'active' : '' }}">
            Campaigns
        </a>

        <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'active' : '' }}">
            Products
        </a>

        <a href="{{ route('price-books.index') }}" class="{{ request()->routeIs('price-books.*') ? 'active' : '' }}">
            Price Books
        </a>

        <a href="{{ route('quotes.index') }}" class="{{ request()->routeIs('quotes.*') ? 'active' : '' }}">
            Quotes
        </a>

        <a href="{{ route('sales-orders.index') }}" class="{{ request()->routeIs('sales-orders.*') ? 'active' : '' }}">
            Sales Orders
        </a>

        <a href="{{ route('invoices.index') }}" class="{{ request()->routeIs('invoices.*') ? 'active' : '' }}">
            Invoices
        </a>

        <a href="{{ route('payments.index') }}" class="{{ request()->routeIs('payments.*') ? 'active' : '' }}">
            Payments
        </a>

        <a href="{{ route('reports.index') }}" class="{{ request()->routeIs('reports.*') ? 'active' : '' }}">
            Reports
        </a>

        <form method="POST" action="{{ route('logout') }}" class="mt-4">
            @csrf
            <button class="btn btn-outline-light w-100">
                Logout
            </button>
        </form>
    </aside>

    <main class="crm-main">
        <div class="crm-topbar">
            <form action="{{ route('search.index') }}" method="GET" style="width: 420px;">
                <input type="text"
                    name="search"
                    class="form-control"
                    value="{{ request('search') }}"
                    placeholder="Search CRM...">
            </form>

            <div>
                {{ auth()->user()->name ?? 'User' }}
            </div>
        </div>

        <div class="crm-content">
            @yield('content')
        </div>
    </main>
</div>
</body>
</html>
