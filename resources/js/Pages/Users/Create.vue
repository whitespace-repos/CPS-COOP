<script setup>
import BreezeButton from '@/Components/Button.vue';
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
    phone:'',
    shop_id:'',
});

const submit = () => {
    form.post(route('user.store'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<script>
    export default {
        props:['shops'],
        computed (){
        $('select').selectpicker();
        },
        mounted() {
        $('select').selectpicker();
        }
    }
</script>


<template>
    <BreezeAuthenticatedLayout>
        <Head title="Register" />

        <div class="main-panel">
            <div class="StoreDiv">
                <h3>Add New User</h3>
                <BreezeValidationErrors class="mb-4 " />

                <form @submit.prevent="submit" class="">
                    <div class="ShopFrm">
                        <ul>
                        <li>
                            <label>Full Name</label>
                            <input v-model="form.name" placeholder="Type name here" class="form-control" />
                        </li>
                        <li>
                            <label>Email</label>
                            <input v-model="form.email" placeholder="Type email address here" class="form-control" />
                        </li>
                        <li>
                            <label>Phone</label>
                            <input v-model="form.phone" placeholder="Type phone number here" class="form-control" />
                        </li>
                        <li>
                            <label>Password</label>
                            <input v-model="form.password" placeholder="Type password here" class="form-control" />
                        </li>
                        <li>
                            <label>Shop</label>
                            <select class="form-control" v-model="form.shop_id">
                                <template v-for="shop in shops" :key="shop.id">
                                <option  :value="shop.id">{{ shop.shop_name }}</option>
                                </template>
                            </select>
                        </li>
                        <li>
                            <button class="btn btn-primary add-btn" type="submit" >Add Employee</button>
                        </li>
                        </ul>
                    </div>
                </form>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
