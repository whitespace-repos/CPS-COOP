<template>
  <form @submit.prevent="onSubmit">
    <!-- Email -->
    <div class="form-group" :class="{ 'has-error': v$.form.email.$errors.length }">
      <label for="">Email</label>
      <input class="form-control" placeholder="Enter your username"  v-model="v$.form.email.$model">
          <!-- error message -->
      <template v-for="(error, index) of v$.form.email.$errors" :key="index">
        <span class="error-msg">{{ error.$message }}</span>
      </template>
    </div>

    <!-- password -->
    <div class="form-group" :class="{ error: v$.form.password.$error }">
      <label for="">Password</label>
      <input class="form-control" placeholder="Enter your password" type="password" v-model="v$.form.password.$model">
      <div class="pre-icon os-icon os-icon-fingerprint"></div>
          <!-- error message -->
        <div class="error-msg">{{v$.form.password.$error}}</div>
    </div>

     <!-- number -->
    <div class="form-group" :class="{ '': v$.form.abc.$error }">
      <label for="">Number</label>
      <input class="form-control" placeholder="Enter your password" v-model="v$.form.abc.$model">
      <div class="pre-icon os-icon os-icon-fingerprint"></div>
          <!-- error message -->
       <template v-for="(error, index) of v$.form.abc.$errors" :key="index">
        <small class="d-block">{{ error.$message }}</small>
      </template>
    </div>

    <!-- Submit Button -->
    <div class="buttons-w">
      <button :disabled="v$.form.$invalid" class="btn btn-primary">Login</button>
    </div>

  </form>
</template>
<script>
import useVuelidate from '@vuelidate/core'
import { required, email, minLength , numeric , integer ,helpers} from '@vuelidate/validators'
const rateValidation = (value) => value > 0;

export default {
  setup () {
    return { v$: useVuelidate() }
  },

  data() {
    return {
      form: {
        email: '',
        password: '',
        abc:0,
      },
    }
  },

  validations() {
    return {
      form: {
        email: {
           rateValidation,
           numeric
        },
        password: {
            required,
            min: minLength(6)
        },
        abc:{
            numeric,
            rateValidation:helpers.withMessage('Please Enter a Valid Rate',rateValidation)
        }
      },
    }
  },

}
</script>