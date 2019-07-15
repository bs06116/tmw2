<template>
    <div class="login-form">
        <form action="#" method="post">
            <h2 class="text-center">Log in</h2>
            <p class="alert-danger" v-if="errors">{{errors}}</p>
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Email" v-model="email" required="required">
                <div v-if="$v.$error">
                    <p class="alert-danger" v-if="$v.email.required">Email required</p>
                    <p class="alert-danger" v-if="$v.email.email">Email is not valid</p>
                </div>

            </div>
            <div class="form-group">
                <input type="password" class="form-control" placeholder="Password" v-model="password"
                       required="required">
                <div v-if="$v.$error">
                    <p class="alert-danger" v-if="$v.password.required">Password required</p>
                </div>
            </div>
            <div class="form-group">
                <button type="button" @click.prevent="login()" class="btn btn-primary btn-block">Log in</button>
            </div>
            <div class="clearfix">
                <label class="pull-left checkbox-inline"><input type="checkbox"> Remember me</label>
            </div>
        </form>

    </div>

</template>

<script>
    import { required, email } from "vuelidate/lib/validators";
    import helper from "../helper/consts"

    export default {
        data() {
            return{
                email: "admin@admin.com",
                password: "123456",
                errors:false
            }
        },
        validations: {
               email: { required, email }
        },
        methods: {
            login() {
                this.$v.$touch();
                if (this.$v.$pending || this.$v.$error) return;
                let vm=this
                axios.post(helper.login_api, {
                    email: this.email,
                    password: this.password
                }).then(response =>response.data).then(response => {
                    this.$store.dispatch("setLogged", true)
                    if(response.status){
                        console.info(response.status)
                        this.$router.push({ name: 'all_member' })
                    }
                }).catch(function (error) {
                    vm.errors=error.response.data.msg
                });
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
