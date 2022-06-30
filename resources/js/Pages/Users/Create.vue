<template>
    <BreezeAuthenticatedLayout>
        <Head title="Register" />

        <div class="main-panel">
            <div class="StoreDiv pt-0">
                <h3 class="mb-4">Add New User</h3>
                <BreezeValidationErrors class="mb-4 " />

                <form @submit.prevent="submit">
                    <div class="card">
                        <div class="card-body row">
                            <div class="form-group col-md-4" :class="{ 'has-error': v$.form.name.$errors.length }">
                                <label>Full Name</label>
                                <input v-model="v$.form.name.$model" placeholder="Type name here" class="form-control" />
                                <template v-for="(error, index) of v$.form.name.$errors" :key="index">
                                    <small>{{ error.$message }}</small>
                                </template>
                            </div>
                            <div class="form-group col-md-4" :class="{ 'has-error': v$.form.email.$errors.length }">
                                <label>Email</label>
                                <input v-model="v$.form.email.$model" placeholder="Type email address here" class="form-control" />
                                <template v-for="(error, index) of v$.form.email.$errors" :key="index">
                                    <small>{{ error.$message }}</small>
                                </template>
                            </div>
                            <div class="form-group col-md-4" :class="{ 'has-error': v$.form.phone.$errors.length }">
                                <label>Phone</label>
                                <input v-model="v$.form.phone.$model" placeholder="Type phone number here" class="form-control" />
                                <template v-for="(error, index) of v$.form.phone.$errors" :key="index">
                                    <small>{{ error.$message }}</small>
                                </template>
                            </div>
                            <div class="form-group col-md-4" :class="{ 'has-error': v$.form.password.$errors.length }">
                                <label>Password</label>
                                <input v-model="v$.form.password.$model" placeholder="Type password here" class="form-control" />
                                <template v-for="(error, index) of v$.form.password.$errors" :key="index">
                                    <small>{{ error.$message }}</small>
                                </template>
                            </div>

                            <div class="form-group col-md-4">
                                <label> Role </label>
                                <!-- array of strings or numbers -->
                                <v-select :options="['Employee', 'Supplier']" :clearable="false" v-model="form.role"  :disabled="!auth.isAdmin" :noDrop="!auth.isAdmin"></v-select>
                            </div>


                            <div class="form-group col-md-4">
                                <label>Shop</label>

                                <v-select
                                    v-model="form.shop_id"
                                    :filter="fuseSearch"
                                    :options="filterShopList"
                                    :multiple="(form.role=='Supplier') ? true : false"
                                    :get-option-key="(option) => option.id"
                                    :get-option-label="(option) => option.shop_name"
                                    >
                                    <template #option="{ shop_name, shop_id }">
                                        {{ shop_name }}
                                        <br />
                                        <cite>{{ shop_id }}</cite>
                                    </template>
                                </v-select>
                            </div>



                            <div class="form-group col-md-12">
                                <button class="btn btn-primary add-btn" type="submit" :disabled="v$.form.$invalid">Add {{form.role}}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
    import BreezeButton from '@/Components/Button.vue';
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
    import BreezeInput from '@/Components/Input.vue';
    import BreezeLabel from '@/Components/Label.vue';
    import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
    import { Head, Link, useForm } from '@inertiajs/inertia-vue3';

    import useVuelidate from '@vuelidate/core'
    import { required, email, minLength , numeric , integer ,helpers} from '@vuelidate/validators'
    import Fuse from 'fuse.js'

    export default {
        props:['shops' , 'allShops'],
        components: {
            BreezeAuthenticatedLayout,
            Head,
        },
        data(){
            return {
                form : this
                                  .$inertia
                                  .form({
                            name: '',
                            email: '',
                            password: '',
                            password_confirmation: '',
                            terms: false,
                            phone:'',
                            shop_id:'',
                            role:'Employee'
                        })
            }
        },
        methods: {
            fuseSearch(options, search) {
            const fuse = new Fuse(options, {
                keys: ['shop_name', 'shop_id'],
                shouldSort: true,
            })
            return search.length
                ? fuse.search(search).map(({ item }) => item)
                : fuse.list
            },
            submit(){
                this.form.post(route('user.store'), {
                    onFinish: () => this.form.reset('password', 'password_confirmation'),
                });
            }
        },
        computed:{
                filterShopList () {
                    return (this.form.role == 'Employee') ? this.shops : this.allShops;
                }
        },
        mounted() {

        },
        validations() {
            return {
                    form:{
                            name: { required},
                            email: { email},
                            password: { required},
                            phone:{ required ,numeric },
                            shop_id:{}
                        }
            }
        },
        setup () {
            return { v$: useVuelidate() }
        }
    }
</script>
