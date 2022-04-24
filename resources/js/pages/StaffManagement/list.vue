<template>
	<div class="staff-management">
		<v-app>
			<b-overlay
				:show="overlay.show"
				:variant="overlay.variant"
				:opacity="overlay.opacity"
				:blur="overlay.blur"
				:rounded="overlay.sm"
			>
				<template #overlay>
					<div class="text-center">
						<b-icon icon="arrow-clockwise" font-scale="3" animation="spin" />
						<p style="margin-top: 10px;">{{ $t('OVERLAY.PLEASE_WAIT') }}</p>
					</div>
				</template>

				<v-row class="my-3 mx-3">
					<v-col cols="12">
						<v-card elevation="24">
							<v-card-title>
								<b-row>
									<b-col lg="6" md="12" sm="12" class="text-center">
										<v-text-field
											v-model="search"
											append-icon="mdi-magnify"
											:label="$t('BUTTON.SEARCH')"
											single-line
											hide-details
										/>
									</b-col>

									<b-col lg="6" md="12" sm="12" class="text-center mt-3">
										<v-btn dark class="primary-btn" @click="openRegisterDialog()">
											<span>{{ $t('STAFF_MANAGEMENT.NEW_STAFF') }}</span>
										</v-btn>
									</b-col>
								</b-row>
							</v-card-title>

							<v-data-table
								class="staff-management-list-table mt-3"
								:headers="headers"
								:items="items"
								:search="search"
								item-key="user_name"
								:header-props="{
									sortByText: $t('BUTTON.SORT_BY'),
									sortIcon: null,
								}"
								:footer-props="{
									itemsPerPageText: $t('PAGINATION.DISPLAY_PER_PAGE'),
									itemsPerPageAllText: $t('PAGINATION.ALL'),
									itemsPerPageOption: [10, 20, 50, 100, -1]
								}"
							>
								<template #[`item.actions`]="{ item }">
									<v-row>
										<v-col cols="4" class="text-right">
											<v-icon small class="text-info" @click="getSpecificTask(item.id)">fas fa-address-card</v-icon>
										</v-col>

										<v-col cols="4" class="text-center">
											<v-icon small class="text-primary" @click="getSpecificTask(item.id)">fas fa-edit</v-icon>
										</v-col>

										<v-col cols="4" class="text-left">
											<v-icon small class="text-danger" @click="deleteDialog = true, deleting_id = item.id">fas fa-trash-alt</v-icon>
										</v-col>
									</v-row>
								</template>

								<template #[`item.role_name`]="{ item }">
									<span v-if="item.role_name === 'admin'">{{ $t('ROLE.ADMIN') }}</span>
									<span v-else-if="item.role_name === 'manager'">{{ $t('ROLE.MANAGER') }}</span>
									<span v-else-if="item.role_name === 'staff'">{{ $t('ROLE.STAFF') }}</span>
								</template>

								<template #[`item.department_id`]="{ item }">
									<span>{{ convertFromIDToName(item.department_id, DepartmentList) }}</span>
								</template>

								<template #[`item.position_id`]="{ item }">
									<span>{{ convertFromIDToName(item.position_id, PositionList) }}</span>
								</template>

								<template #[`item.contract_id`]="{ item }">
									<span>{{ convertFromIDToName(item.contract_id, ContractType) }}</span>
								</template>
							</v-data-table>
						</v-card>
					</v-col>
				</v-row>
			</b-overlay>
		</v-app>
	</div>
</template>

<script>
import {
    getAllUser,
    getOneUser,
    createUser,
    updateUser,
    deleteUser,
}
from '@/api/modules/user';

import { getAllPosition } from '@/api/modules/position';

import { getAllContract } from '@/api/modules/contract';

import { getAllDepartment } from '@/api/modules/department';

import { MakeToast } from '@/utils/MakeToast';

import { convertFromIDToName } from '@/utils/convertFromIdToName';

const urlAPI = {
    apiGetAllUser: '/users/list',
    apiGetAllPosition: '/position/list',
    apiGetAllContract: '/contract/list',
    apiGetAllDepartment: '/department/list',
    apiGetOneUser: '/users/detail/',
    apiCreateUser: '/users/create',
    apiUpdateUser: '/users/update/',
    apiDeleteUser: '/users/delete/',
};
export default {
    name: 'StaffManagementList',
    data() {
        return {
            overlay: {
                show: false,
                variant: 'light',
                opacity: 1,
                blur: '1rem',
                rounded: 'sm',
            },

            convertFromIDToName: convertFromIDToName,

            user: {
                user_name: '',
                user_code: '',
                email: '',
                dob: '',
                participated_date: '',
                address: '',
                phone_number: '',
                is_retired: '',
                avatar: '',
                role_id: '',
                department_id: '',
                position_id: '',
                contract_id: '',
            },

            headers: [
                { text: this.$t('STAFF_MANAGEMENT.USER_NAME'), sortable: false, value: 'user_name' },
                { text: this.$t('STAFF_MANAGEMENT.USER_CODE'), sortable: false, value: 'user_code' },
                { text: this.$t('STAFF_MANAGEMENT.ROLE'), sortable: false, value: 'role_name' },
                { text: this.$t('STAFF_MANAGEMENT.DEPARTMENT'), sortable: false, value: 'department_id' },
                { text: this.$t('STAFF_MANAGEMENT.POSITION'), sortable: false, value: 'position_id' },
                { text: this.$t('STAFF_MANAGEMENT.CONTRACT'), sortable: false, value: 'contract_id' },
                { text: this.$t('BUTTON.ACTIONS'), sortable: false, value: 'actions' },
            ],

            items: [],

            PositionList: [],

            ContractType: [],

            DepartmentList: [],

            search: '',

            registerDialog: false,

            editDialog: false,

            deleteDialog: false,
            deleting_id: '',

            language: this.$store.getters.language,
        };
    },
    created() {
        this.getUserList();
        this.getPositionList();
        this.getContractType();
        this.getDepartmentList();
    },
    methods: {
        async getUserList() {
            this.overlay.show = true;

            try {
                const response = await getAllUser(urlAPI.apiGetAllUser);

                if (response.code === 200) {
                    this.items = response.data;
                }
            } catch (error) {
                MakeToast({
                    variant: 'warning',
                    title: this.$t('TOAST.TITLE.WARNING'),
                    content: error || this.$t('TOAST.TITLE.ERROR'),
                });
            }
        },

        async getPositionList() {
            try {
                const response = await getAllPosition(urlAPI.apiGetAllPosition);

                if (response.code === 200) {
                    for (let i = 0; i < response.data.length; i++) {
                        this.PositionList.push({
                            text: this.$t(`POSITION.${response.data[i].position_name}`),
                            value: response.data[i].id,
                        });
                    }
                }
            } catch (error) {
                console.log(error);
            }
        },

        async getContractType() {
            try {
                const response = await getAllContract(urlAPI.apiGetAllContract);

                if (response.code === 200) {
                    for (let i = 0; i < response.data.length; i++) {
                        this.ContractType.push({
                            text: this.$t(`CONTRACT.${response.data[i].contract_type}`),
                            value: response.data[i].id,
                        });
                    }
                }
            } catch (error) {
                console.log(error);
            }
        },

        async getDepartmentList() {
            try {
                const response = await getAllDepartment(urlAPI.apiGetAllDepartment);

                if (response.code === 200) {
                    for (let i = 0; i < response.data.length; i++) {
                        this.DepartmentList.push({
                            text: response.data[i].department_name,
                            value: response.data[i].id,
                        });
                    }
                }
            } catch (error) {
                console.log(error);
            }

            this.overlay.show = false;
        },

        async getSpecificUser(user_id) {
            this.user = {
                user_name: '',
                user_code: '',
                email: '',
                dob: '',
                participated_date: '',
                address: '',
                phone_number: '',
                is_retired: '',
                avatar: '',
                role_id: '',
                department_id: '',
                position_id: '',
                contract_id: '',
            };

            this.editDialog = true;

            const URL = `${urlAPI.apiGetOneUser}${user_id}`;

            try {
                const response = await getOneUser(URL);

                if (response.code === 200) {
                    this.user = response.data;
                }
            } catch (error) {
                console.log(error);
            }
        },

        openRegisterDialog() {
            this.user = {
                user_name: '',
                user_code: '',
                email: '',
                dob: '',
                participated_date: '',
                address: '',
                phone_number: '',
                is_retired: '',
                avatar: '',
                role_id: '',
                department_id: '',
                position_id: '',
                contract_id: '',
            };

            this.registerDialog = true;
        },

        async doRegisterUser() {
            try {
                const response = await createUser(urlAPI.apiCreateUser, this.user);

                if (response.code === 201) {
                    await this.getUserList();

                    MakeToast({
                        variant: 'success',
                        title: this.$t('TOAST.TITLE.SUCCESS'),
                        content: this.$t('TOAST.CONTENT.USER_MANAGEMENT.CREATE_USER_SUCCESS'),
                    });

                    this.registerDialog = false;
                }
            } catch (error) {
                MakeToast({
                    variant: 'warning',
                    title: this.$t('TOAST.TITLE.WARNING'),
                    content: error || this.$t('TOAST.CONTENT.USER_MANAGEMENT.CREATE_USER_FAILED'),
                });

                this.registerDialog = false;
            }
        },

        async doUpdateUser(user_id) {
            const URL = `${urlAPI.apiUpdateUser}${user_id}`;

            try {
                const response = await updateUser(URL, this.user);

                if (response.code === 200) {
                    await this.getUserList();

                    MakeToast({
                        variant: 'success',
                        title: this.$t('TOAST.TITLE.SUCCESS'),
                        content: this.$t('TOAST.CONTENT.USER_MANAGEMENT.UPDATE_USER_SUCCESS'),
                    });

                    this.editDialog = false;
                }
            } catch (error) {
                MakeToast({
                    variant: 'warning',
                    title: this.$t('TOAST.TITLE.WARNING'),
                    content: error || this.$t('TOAST.CONTENT.USER_MANAGEMENT.UPDATE_USER_FAILED'),
                });

                this.editDialog = false;
            }
        },

        async doRemoveUser(user_id) {
            const URL = `${urlAPI.apiDeleteUser}${user_id}`;

            try {
                const response = await deleteUser(URL);
                if (response.code === 200) {
                    this.getUserList();

                    MakeToast({
                        variant: 'success',
                        title: this.$t('TOAST.TITLE.SUCCESS'),
                        content: this.$t('TOAST.CONTENT.USER_MANAGEMENT.DELETE_USER_SUCCESS'),
                    });

                    this.deleteDialog = false;
                }
            } catch (error) {
                MakeToast({
                    variant: 'warning',
                    title: this.$t('TOAST.TITLE.WARNING'),
                    content: error || this.$t('TOAST.CONTENT.USER_MANAGEMENT.DELETE_USER_FAILED'),
                });

                this.deleteDialog = false;
            }
        },
    },
};
</script>

<style lang="scss" scoped>
  @import "@/scss/variables.scss";

  .staff-management {

    ::v-deep .v-dialog {
      overflow-y: visible;
    }

    .staff-management-list-table {
      ::v-deep th {
        font-weight: bolder !important;
        color: $white !important;
        background-color: $cloud-burst;
      }

      ::v-deep th {
        text-align: center !important;
      }

      ::v-deep td {
        text-align: center !important;
      }
    }
  }

  @media (max-width: 768px) {
    .staff-management {
      max-height: 100%;
    }
  }
</style>
