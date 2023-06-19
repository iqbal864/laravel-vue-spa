<template>
    <div>
        <section>
            <h1>Daftar User</h1>
            <router-link v-bind:to="{ name: 'Register' }">Register</router-link>
            <table style="width:100%;" class="table table-striped table-bordered" id="table_user">
                <thead class="table-dark">
                    <tr>
                        <th>No.</th>
                        <th style="text-align: left;">Nama</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- <tr v-for="user in users">
                        <td>{{ user.no }}</td>
                        <td>{{ user.name }}</td>
                        <td v-html="user.action"> -->
                    <!-- <router-link v-bind:to="profile_uri(user.name)">View</router-link> -->
                    <!-- <a href="" @click.prevent="lihatuser(user.id)">Lihat</a>
                            <a href="" @click.prevent="handledelete(user.id)">Hapus</a> -->
                    <!-- </td>
                    </tr> -->
                </tbody>
            </table>
        </section>
    </div>
</template>

<script>

export default {
    data() {
        return {
            users: null
        }
    },
    mounted() {
        this.getUser()
    },
    methods: {
        getUser() {
            // axios.get('/api/users').then((response) => {
            // console.log(response.data.data);
            // this.users = response.data;

            this.users = $('#table_user').DataTable({
                "processing": true,
                "serverSide": true,
                "method": "GET",
                "ajax": '/api/users',
                "columns": [
                    { "data": "no" },
                    { "data": "name" },
                    { "data": "action" }
                ]
            })

            this.users.on('click', '.lihatuser', (event) => {
                event.preventDefault();
                this.lihatuser($(event.target).data('id'));
                // console.log($(event.target).data('id'));
            });

            this.users.on('click', '.handleedit', (event) => {
                event.preventDefault();
                this.handleedit($(event.target).data('id'));
                // console.log($(event.target).data('id'));
            });

            this.users.on('click', '.handledelete', (event) => {
                event.preventDefault();
                this.handledelete($(event.target).data('id'), $(event.target).data('name'));
                // console.log($(event.target).data('id'));
            });
            // });

            // fetch('/api/users')
            // .then(response => response.json())
            // .then(data => {
            //     console.log(data);
            //     this.users = data;
            // });

        },
        profile_uri(name) {
            return '/user/' + name;
        },
        lihatuser(id) {
            this.$router.push('/user/' + id);
            // this.$router.push({
            //     name: 'User',
            //     params: {
            //         id: id
            //     }
            // });
        },
        handleedit(id) {
            // this.$router.push('/user/' + id);
            this.$router.push({
                name: 'Edit',
                params: {
                    id: id
                }
            });
        },
        handledelete(id, name) {
            // const cekindex = this.users.findIndex(p => p.id === id);
            // console.log(cekindex);
            this.$swal({
                title: 'Apakah kamu yakin?',
                text: "Kamu akan menghapus user " + name + "!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: "Batal",
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete('/api/users/' + id).then((response) => {
                        if (response.data.status == true) {
                            // const userlist = this.users.findIndex(p => p.id === id);
                            // this.users.splice(userlist, 1);

                            // this.users = response.data.data;

                            this.users.draw();

                            const Toast = this.$swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', this.$swal.stopTimer)
                                    toast.addEventListener('mouseleave', this.$swal.resumeTimer)
                                }
                            })

                            Toast.fire({
                                icon: 'success',
                                title: response.data.message
                            })
                        }
                    });
                }
            })
        },
    }
}
</script>
