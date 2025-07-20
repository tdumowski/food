@php
    $id = Auth::guard('client')->id();
    $client = App\Models\Client::findOrFail($id);
    $status = $client->status;
@endphp

<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" data-key="t-menu">Menu</li>

                <li>
                    <a href="{{ route('client.dashboard') }}" class="waves-effect">
                        <i data-feather="home"></i>
                        <span data-key="t-dashboard">Dashboard</span>
                    </a>
                </li>

                @if($status)
                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <i data-feather="grid"></i>
                            <span data-key="t-apps">Menu</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li>
                                <a href="{{ route('all.menu') }}">
                                    <span data-key="t-calendar">All menus</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('add.menu') }}">
                                    <span data-key="t-calendar">Add menu</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <i data-feather="grid"></i>
                            <span data-key="t-apps">Product</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li>
                                <a href="{{ route('all.product') }}">
                                    <span data-key="t-calendar">All products</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('add.product') }}">
                                    <span data-key="t-calendar">Add product</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <i data-feather="grid"></i>
                            <span data-key="t-apps">Gallery</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li>
                                <a href="{{ route('all.gallery') }}">
                                    <span data-key="t-calendar">All gallery</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('add.product') }}">
                                    <span data-key="t-calendar">Add gallery</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <i data-feather="grid"></i>
                            <span data-key="t-apps">Coupon</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li>
                                <a href="{{ route('all.coupon') }}">
                                    <span data-key="t-calendar">All coupon</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('add.coupon') }}">
                                    <span data-key="t-calendar">Add coupon</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <i data-feather="grid"></i>
                            <span data-key="t-apps">Manage orders</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li>
                                <a href="{{ route('all.client.orders') }}">
                                    <span data-key="t-calendar">All orders</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <i data-feather="grid"></i>
                            <span data-key="t-apps">Manage reports</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li>
                                <a href="{{ route('client.all.reports') }}">
                                    <span data-key="t-calendar">All reports</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <i data-feather="briefcase"></i>
                            <span data-key="t-components">Manage reviews</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ route('client.all.reviews') }}" data-key="t-alerts">All reviews</a></li>
                        </ul>
                    </li>
                @endif
            </ul>

            <div class="card sidebar-alert border-0 text-center mx-4 mb-0 mt-5">
                <div class="card-body">
                    <img src="assets/images/giftbox.png" alt="">
                    <div class="mt-4">
                        <h5 class="alertcard-title font-size-16">Unlimited Access</h5>
                        <p class="font-size-13">Upgrade your plan from a Free trial, to select ‘Business Plan’.</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Sidebar -->
    </div>
</div>
