<template>
    <div>
        <section>
            <h1>Data User {{ detailUser.name }}</h1>
            <p>Email: {{ detailUser.email }}</p>
            <!-- <router-link v-bind:to="{name: 'User'}">Kembali</router-link> -->
            <a href="javascript:void(0)" @click.prevent="kembali()">Kembali</a>
            <!-- <router-link v-bind:to="kembali()">Kembali</router-link> -->
        </section>
    </div>
</template>

<script>

export default {
    props: ['id'],
    data() {
        return {
            detailUser: {}
        }
    },
    mounted() {
        this.getUser()
    },
    methods: {
        getUser() {
            axios.get('/api/users/' + this.id).then((response) => {
                // console.log(response);
                this.detailUser = response.data;
            });

            // fetch('/api/users')
            // .then(response => response.json())
            // .then(data => {
            //     console.log(data);
            //     this.users = data;
            // });

        },
        kembali() {
            this.$router.push('/user');
            // return '/user'
        }
    }
}
</script>
