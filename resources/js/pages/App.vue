<template>
	<div id="app">
		<router-view />
	</div>
</template>

<script>
export default {
    name: 'App',
    created() {
        console.log(
            '%cHomestay Internal Management System',
            'font-size: 20px; padding: 5px 10px 5px 10px; border-radius: .25rem; color: rgb(255, 209, 84); background-color: rgb(0, 39, 149); text-align: center;'
        );
    },
    mounted() {
        const ROLES = this.$store.getters.roles;
        const PERMISSIONS = this.$store.getters.permissions;

        this.$store.dispatch('permissions/generateRoutes', { roles: ROLES, permissions: PERMISSIONS })
            .then((routes) => {
                for (let route = 0; route < routes.length; route++) {
                    this.$router.addRoute(routes[route]);
                }
            });
    },
};
</script>
