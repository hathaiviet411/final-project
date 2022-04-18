<template>
	<div class="nav-bar">
		<b-navbar toggleable="lg" type="dark" align="center">
			<b-navbar-brand @click.prevent.stop="[$emit('toggle'), toggleIcon = !toggleIcon]">
				<i v-if="toggleIcon === true" id="toggle-menu" class="fas fa-toggle-on" />
				<i v-else id="toggle-menu" class="fas fa-toggle-off" />
			</b-navbar-brand>

			<b-navbar-nav class="izumi-logo-container">
				<v-img :src="require('@/assets/images/logo.png')" />
			</b-navbar-nav>

			<b-navbar-toggle target="nav-collapse">
				<template #default="{ expanded }">
					<i v-if="expanded" class="fas fa-angle-up" />
					<i v-else class="fas fa-angle-down" />
				</template>
			</b-navbar-toggle>

			<b-collapse id="nav-collapse" is-nav>
				<b-navbar-nav class="ml-auto">
					<b-nav-item>
						<vButton style="font-weight: bold;" class="btn-show-emp-name" :text-button="employeeName" />
					</b-nav-item>

					<b-nav-item>
						<DateSelector />
					</b-nav-item>

					<DepartmentSelector />

					<b-nav-item>
						<vButton style="font-weight: bold;" class="btn-logout" :text-button="$t('NAVBAR.LOGOUT')" @click.native="doLogout()" />
					</b-nav-item>
				</b-navbar-nav>
			</b-collapse>
		</b-navbar>
	</div>
</template>

<script>
import vButton from '@/components/atoms/vButton';
import DepartmentSelector from '../DepartmentSelector/index';
import DateSelector from '../DateSelector/index';

export default {
    name: 'Navbar',
    components: {
        vButton,
        DepartmentSelector,
        DateSelector,
    },
    data() {
        return {
            listData: [],
            width: window.innerWidth,

            toggleIcon: true,
        };
    },
    computed: {
        employeeName() {
            return this.$store.getters.name;
        },
    },
    created() {
        window.addEventListener('resize', this.onResize);
    },
    destroyed() {
        window.removeEventListener('resize', this.onResize);
    },
    methods: {
        onResize(e) {
            this.width = window.innerWidth;
        },
        async doLogout() {
            await this.$store.dispatch('user/doLogout')
                .then(() => {
                    this.$toast.success({
                        content: this.$t('TOAST.CONTENT.LOGOUT.SUCCESS'),
                    });

                    this.$router.push('/login');
                })
                .catch(() => {
                    this.$toast.danger({
                        content: this.$t('TOAST.OTHER.ERROR'),
                    });
                });
            await this.$store.dispatch('department/setClearDate');
            await this.$store.dispatch('time/setClearDate');
            await this.$store.dispatch('permissions/setClearDate');
        },
    },
};
</script>

<style lang="scss" scoped>
    @import '@/scss/variables.scss';
    @import '@/scss/modules/layout.scss';

    #toggle-menu {
      font-size: 30px;
      color: $cloud-burst;
    }

    #toggle-menu:hover {
      cursor: pointer;
    }

    .dropdown-content-scrollable {
        height: 240px;
        overflow-x: hidden;
        overflow-y: auto;
    }
</style>
