<template>
    <header id="header" class="fixed-top" >
        <div class="custom-container">
            <div class="logo">
                <Link :href="route('dashboard')">
                    <img src="/assets/img/logo.png" alt="logo">
                </Link>
                <button class="menuBtn"><img src="/assets/img/list.png" alt=""></button>
            </div>

            <h4 class="m-auto text-danger heading"> {{ 'COOP - ' + $page.props.shop.shop_name }} </h4>
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
    <main id="main" style="height: calc(100vh - 90px);padding-top: 90px;">
        <slot />
    </main>
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
