<template>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-sm-6 mt-5">
                <h2>Register</h2>
                <p class="text-danger" v-for="error in errors" :key="error">
                    <span v-for="err in error" :key="err">{{ err }}</span>
                </p>
                <form @submit.prevent="register">
                    <div class="form-group">
                        <label for="name">Full Name: </label>
                        <input type="text" class="form-control" id="name" v-model="form.name">
                    </div>
                    <div class="form-group">
                        <label for="email">Email: </label>
                        <input type="email" class="form-control" id="email" v-model="form.email">
                    </div>
                    <div class="form-group">
                        <label for="password">Password: </label>
                        <input type="password" class="form-control" id="password" v-model="form.password">
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirm Password: </label>
                        <input type="password" class="form-control" id="confirm_password" v-model="form.confirm_password">
                    </div>
                    <button type="submit" class="btn btn-success">Register</button>
                </form>
            </div>

        </div>
    </div>
</template>
<script>
import { reactive, ref } from 'vue'
import { useRouter } from "vue-router"
export default{
    setup() {
        const router = useRouter()
        let form = reactive({
            name : '',
            email: '',
            password: '',
            confirm_password : ''
        });

        let errors = ref([])

        const register = async()=>{
            await axios.post('/api/register', form).then(res=>{
                if(res.data.success){
                    localStorage.setItem('token', res.data.data.token)
                    router.push({name:'ChatGpt'})
                }
            }).catch(e=>{
                    errors.value = e.response.data.message
                })
        }

        return{
            form,
            register,
            errors
        }
    }
}
</script>