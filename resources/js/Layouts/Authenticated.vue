<template>
    <header id="header" class="fixed-top" >
        <div class="custom-container">
            <div class="logo">
                <Link :href="route('dashboard')">
                    <img src="/assets/img/logo.png" alt="logo">
                </Link>
                <button class="menuBtn"><img src="/assets/img/list.png" alt=""></button>
            </div>
            <div class="header-top-language d-flex">
                <button class="btn dropdown-toggle header-action-btn" type="button" id="languageButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <label>{{ $page.props.auth.user.name }}</label>
                </button>
                <ul class="dropdown-menu" aria-labelledby="languageButton">
                    <li><Link href="/logout" method="post" as="button" type="button" class="dropdown-item">Logout</Link> </li>
                </ul>
            </div>
        </div>
    </header>
    <!-- Page Content -->
    <section>
        <div class="wrapper">
            <div class="sideBar">
                <ul>
                <li><a href="#"> <img src="/assets/img/menu_icon1.png" alt="icon">
                    <p>Dashboard</p>
                    </a></li>
                <li> <Link href="/product"><img src="/assets/img/menu_icon2.png" alt="icon">
                    <p>Products</p>
                    </Link> </li>
                <li><Link href="/shop"> <img src="/assets/img/menu_icon3.png" alt="icon">
                    <p>Shops</p>
                    <!-- <small>01</small>  -->
                    </Link></li>
                <li><Link  href="/rate"> <img src="/assets/img/menu_icon4.png" alt="icon">
                    <p>Rate</p>
                    </Link ></li>
                <li><Link href="/user"> <img src="/assets/img/menu_icon5.png" alt="icon">
                    <p>Users</p>
                    </Link></li>
                <li><a href="#"> <img src="/assets/img/menu_icon6.png" alt="icon">
                    <p>Expenses</p>
                    </a></li>
                <li><a href="#"> <img src="/assets/img/menu_icon7.png" alt="icon">
                    <p>Repayment-EMI</p>
                    </a></li>
                <li><a href="#"> <img src="/assets/img/menu_icon8.png" alt="icon">
                    <p>Reports</p>
                    </a></li>
                </ul>
            </div>
            <main>
                <slot />
            </main>
        </div>
    </section>
</template>

<script>
import BreezeApplicationLogo from '@/Components/ApplicationLogo.vue'
import BreezeDropdown from '@/Components/Dropdown.vue'
import BreezeDropdownLink from '@/Components/DropdownLink.vue'
import BreezeNavLink from '@/Components/NavLink.vue'
import BreezeResponsiveNavLink from '@/Components/ResponsiveNavLink.vue'
import { Link } from '@inertiajs/inertia-vue3';

export default {
    components: {
        BreezeApplicationLogo,
        BreezeDropdown,
        BreezeDropdownLink,
        BreezeNavLink,
        BreezeResponsiveNavLink,
        Link,
    },

    data() {
        return {
            showingNavigationDropdown: false,
        }
    },
}

</script>
