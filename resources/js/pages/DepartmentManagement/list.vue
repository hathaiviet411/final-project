<template>
	<div class="department-management">
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
									<b-col lg="6" md="12" sm="12" xs="12" class="text-center">
										<v-text-field
											v-model="search"
											append-icon="mdi-magnify"
											:label="$t('BUTTON.SEARCH')"
											single-line
											hide-details
										/>
									</b-col>

									<b-col lg="6" md="12" sm="12" xs="12" class="text-center">
										<v-btn color="#1e2a55" width="285" dark class="mt-3" @click="openRegisterDialog()">
											<span style="color: #FFFFFF;">{{ $t('DEPARTMENT_MANAGEMENT.NEW_DEPARTMENT') }}</span>
										</v-btn>
									</b-col>
								</b-row>
							</v-card-title>

							<v-data-table
								class="department-management-list-table mt-3"
								:headers="headers"
								:items="items"
								:search="search"
								item-key="department_name"
								:footer-props="{
									itemsPerPageText: $t('PAGINATION.DISPLAY_PER_PAGE'),
									itemsPerPageAllText: $t('PAGINATION.ALL'),
									itemsPerPageOption: [10, 20, 50, 100, -1]
								}"
							>
								<template #[`item.total_staff`]="{ item }">
									<span>{{ item.total_staff ? item.total_staff : 0 }}</span>
								</template>

								<template #[`item.actions`]="{ item }">
									<v-row>
										<v-col cols="6" class="text-right">
											<v-icon small class="text-primary" @click="getSpecificDepartment(item.id)">fas fa-edit</v-icon>
										</v-col>

										<v-col cols="6" class="text-left">
											<v-icon small class="text-danger" @click="deleteDialog = true, deleting_id = item.id">fas fa-trash-alt</v-icon>
										</v-col>
									</v-row>
								</template>
							</v-data-table>
						</v-card>
					</v-col>
				</v-row>

				<!-- Register Dialog -->
				<v-dialog v-model="registerDialog" max-width="500" persistent>
					<v-card>
						<v-btn elevation="3" block tile class="mb-3 cornflower">
							<span>{{ $t('DEPARTMENT_MANAGEMENT.NEW_DEPARTMENT') }}</span>
						</v-btn>

						<v-card-text>
							<v-row class="mt-1">
								<!-- Department Name -->
								<v-col cols="12">
									<v-text-field
										v-model="department.department_name"
										:label="$t('DEPARTMENT_MANAGEMENT.DEPARTMENT_NAME')"
										outlined
									/>
								</v-col>

								<!-- Department Address -->
								<v-col cols="12">
									<v-text-field
										v-model="department.department_address"
										:label="$t('DEPARTMENT_MANAGEMENT.DEPARTMENT_ADDRESS')"
										outlined
									/>
								</v-col>

								<!-- Department Manager -->
								<v-col cols="12">
									<v-select
										v-model="department.department_manager"
										:label="$t('DEPARTMENT_MANAGEMENT.DEPARTMENT_MANAGER')"
										:items="UserList"
										:item-disabled="item => item.value === null"
										outlined
									/>
								</v-col>

								<!-- Organized Date -->
								<v-col cols="12">
									<v-dialog
										v-model="modalOrganizedDate"
										:scrollable="false"
										max-width="250"
									>
										<template #activator="{ on, attrs }">
											<v-text-field
												v-model="department.organized_date"
												:label="$t('DEPARTMENT_MANAGEMENT.ORGANIZED_DATE')"
												readonly
												outlined
												v-bind="attrs"
												v-on="on"
											/>
										</template>

										<v-date-picker
											v-model="department.organized_date"
											show-current
											:locale="language"
											elevation="24"
											width="250"
											color="green lighten-1"
											@input="modalOrganizedDate = false"
										/>
									</v-dialog>
								</v-col>
							</v-row>
						</v-card-text>

						<v-card-actions>
							<v-row>
								<v-col cols="6" class="text-center">
									<v-btn class="danger-btn" @click="registerDialog = false">
										<v-icon left>mdi-close-box</v-icon>
										<span>{{ $t('BUTTON.CANCEL') }}</span>
									</v-btn>
								</v-col>

								<v-col cols="6" class="text-center">
									<v-btn class="primary-btn" @click="doRegisterDepartment()">
										<v-icon left>fas fa-plus-circle</v-icon>
										<span>{{ $t('BUTTON.REGISTER') }}</span>
									</v-btn>
								</v-col>
							</v-row>
						</v-card-actions>
					</v-card>
				</v-dialog>

				<!-- Edit Dialog -->
				<v-dialog v-model="editDialog" max-width="500" persistent>
					<v-card>
						<v-btn elevation="3" block tile class="mb-3 cornflower">
							<span>{{ $t('DEPARTMENT_MANAGEMENT.EDIT_DEPARTMENT') }}</span>
						</v-btn>

						<v-card-text>
							<v-row class="mt-1">
								<!-- Department Name -->
								<v-col cols="12">
									<v-text-field
										v-model="department.department_name"
										:label="$t('DEPARTMENT_MANAGEMENT.DEPARTMENT_NAME')"
										outlined
									/>
								</v-col>

								<!-- Department Address -->
								<v-col cols="12">
									<v-text-field
										v-model="department.department_address"
										:label="$t('DEPARTMENT_MANAGEMENT.DEPARTMENT_ADDRESS')"
										outlined
									/>
								</v-col>

								<!-- Department Manager -->
								<v-col cols="12">
									<v-select
										v-model="department.department_manager"
										:label="$t('DEPARTMENT_MANAGEMENT.DEPARTMENT_MANAGER')"
										:items="UserList"
										:item-disabled="item => item.value === null"
										outlined
									/>
								</v-col>

								<!-- Organized Date -->
								<v-col cols="12">
									<v-dialog
										v-model="modalOrganizedDate"
										:scrollable="false"
										max-width="250"
									>
										<template #activator="{ on, attrs }">
											<v-text-field
												v-model="department.organized_date"
												:label="$t('DEPARTMENT_MANAGEMENT.ORGANIZED_DATE')"
												readonly
												outlined
												v-bind="attrs"
												v-on="on"
											/>
										</template>

										<v-date-picker
											v-model="department.organized_date"
											show-current
											:locale="language"
											elevation="24"
											width="250"
											color="green lighten-1"
											@input="modalOrganizedDate = false"
										/>
									</v-dialog>
								</v-col>
							</v-row>
						</v-card-text>

						<v-card-actions>
							<v-row>
								<v-col cols="6" class="text-center">
									<v-btn class="danger-btn" @click="editDialog = false">
										<v-icon left>mdi-close-box</v-icon>
										<span>{{ $t('BUTTON.CANCEL') }}</span>
									</v-btn>
								</v-col>

								<v-col cols="6" class="text-center">
									<v-btn class="primary-btn" @click="doUpdateDepartment(department.id)">
										<v-icon left>fas fa-plus-circle</v-icon>
										<span>{{ $t('BUTTON.SAVE') }}</span>
									</v-btn>
								</v-col>
							</v-row>
						</v-card-actions>
					</v-card>
				</v-dialog>

				<!-- Delete Dialog -->
				<v-dialog v-model="deleteDialog" max-width="500" persistent>
					<v-card>
						<v-btn elevation="3" block tile class="mb-3 cornflower">
							<span>{{ $t('DEPARTMENT_MANAGEMENT.DELETE_DEPARTMENT') }}</span>
						</v-btn>

						<v-card-text>
							<v-row class="mt-1">
								<v-col cols="12" class="text-center">
									<h5>{{ $t('MODAL.DELETE_CONFIRMATION') }}</h5>
								</v-col>
							</v-row>
						</v-card-text>

						<v-card-actions>
							<v-row>
								<v-col cols="6" class="text-center">
									<v-btn class="primary-btn" @click="deleteDialog = false">
										<v-icon left>mdi-close-box</v-icon>
										<span>{{ $t('MODAL.NO') }}</span>
									</v-btn>
								</v-col>

								<v-col cols="6" class="text-center">
									<v-btn class="danger-btn" @click="doRemoveDepartment(deleting_id)">
										<v-icon left>fas fa-eraser</v-icon>
										<span>{{ $t('MODAL.YES') }}</span>
									</v-btn>
								</v-col>
							</v-row>
						</v-card-actions>
					</v-card>
				</v-dialog>
			</b-overlay>
		</v-app>
	</div>
</template>

<script>
import { getAllDepartment, getOneDepartment, createDepartment, updateDepartment, deleteDepartment } from '@/api/modules/department';

import { getAllUser } from '@/api/modules/user';

import { getYMDFromString } from '@/utils/getYMDFromString';

import { MakeToast } from '@/utils/MakeToast';

const urlAPI = {
    apiGetAllDepartment: '/department/list',
    apiGetAllUser: '/users/all',
    apiGetOneDepartment: '/department/detail/',
    apiCreateDepartment: '/department/create',
    apiUpdateDepartment: '/department/update/',
    apiDeleteDepartment: '/department/delete/',
};

export default {
    name: 'DepartmentManagementList',
    data() {
        return {
            overlay: {
                show: false,
                variant: 'light',
                opacity: 1,
                blur: '1rem',
                rounded: 'sm',
            },

            department: {
                department_name: '',
                department_address: '',
                department_manager: '',
                organized_date: '',
            },

            modalOrganizedDate: false,

            headers: [
                { text: this.$t('DEPARTMENT_MANAGEMENT.DEPARTMENT_NAME'), sortable: false, value: 'department_name' },
                { text: this.$t('DEPARTMENT_MANAGEMENT.DEPARTMENT_ADDRESS'), sortable: false, value: 'department_address' },
                { text: this.$t('DEPARTMENT_MANAGEMENT.TOTAL_STAFF'), sortable: false, value: 'total_staff' },
                { text: this.$t('DEPARTMENT_MANAGEMENT.DEPARTMENT_MANAGER'), sortable: false, value: 'user.user_name' },
                { text: this.$t('DEPARTMENT_MANAGEMENT.ORGANIZED_DATE'), sortable: false, value: 'organized_date' },
                { text: this.$t('BUTTON.ACTIONS'), sortable: false, value: 'actions' },
            ],

            items: [],

            UserList: [
                { value: null, text: this.$t('PLACE_HOLDER.PLEASE_SELECT') },
            ],

            registerDialog: false,

            editDialog: false,

            deleteDialog: false,
            deleting_id: '',

            search: '',

            language: this.$store.getters.language,
        };
    },
    created() {
        this.getDepartmentManagementData();
    },
    methods: {
        async getDepartmentManagementData() {
            await this.getDepartmentList();
            await this.getUserList();
        },

        async getDepartmentList() {
            this.overlay.show = true;

            try {
                const response = await getAllDepartment(urlAPI.apiGetAllDepartment);

                if (response.code === 200) {
                    for (let i = 0; i < response.data.length; i++) {
                        response.data[i].organized_date = getYMDFromString(response.data[i].organized_date);
                    }

                    this.items = response.data;
                }
            } catch (error) {
                console.log(error);
            }
        },

        async getUserList() {
            try {
                const response = await getAllUser(urlAPI.apiGetAllUser);

                if (response.code === 200) {
                    for (let i = 0; i < response.data.length; i++) {
                        this.UserList.push({
                            value: response.data[i].id,
                            text: response.data[i].user_name,
                        });
                    }
                }
            } catch (error) {
                console.log(error);
            }

            this.overlay.show = false;
        },

        async getSpecificDepartment(department_id) {
            this.department = {
                department_name: '',
                department_address: '',
                department_manager: '',
                organized_date: '',
            };

            this.editDialog = true;

            const URL = `${urlAPI.apiGetOneDepartment}${department_id}`;

            try {
                const response = await getOneDepartment(URL);

                if (response.code === 200) {
                    response.data.organized_date = getYMDFromString(response.data.organized_date);
                    this.department = response.data;
                    this.department.department_manager = response.data.user_id;
                }
            } catch (error) {
                console.log(error);
            }
        },

        openRegisterDialog() {
            this.department = {
                department_name: '',
                department_address: '',
                department_manager: '',
                organized_date: '',
            };

            this.registerDialog = true;
        },

        async doRegisterDepartment() {
            try {
                this.department.department_manager = parseInt(this.department.department_manager);
                const response = await createDepartment(urlAPI.apiCreateDepartment, this.department);

                if (response.code === 201) {
                    this.registerDialog = false;

                    await this.getDepartmentManagementData();

                    MakeToast({
                        variant: 'success',
                        title: this.$t('TOAST.TITLE.SUCCESS'),
                        content: this.$t('TOAST.CONTENT.DEPARTMENT_MANAGEMENT.CREATE_DEPARTMENT_SUCCESS'),
                    });
                }
            } catch (error) {
                MakeToast({
                    variant: 'warning',
                    title: this.$t('TOAST.TITLE.WARNING'),
                    content: error || this.$t('TOAST.CONTENT.DEPARTMENT_MANAGEMENT.CREATE_DEPARTMENT_FAILED'),
                });

                this.registerDialog = false;
            }
        },

        async doUpdateDepartment(department_id) {
            const URL = `${urlAPI.apiUpdateDepartment}${department_id}`;

            try {
                const response = await updateDepartment(URL, this.department);

                if (response.code === 200) {
                    this.editDialog = false;

                    await this.getDepartmentManagementData();

                    MakeToast({
                        variant: 'success',
                        title: this.$t('TOAST.TITLE.SUCCESS'),
                        content: this.$t('TOAST.CONTENT.DEPARTMENT_MANAGEMENT.UPDATE_DEPARTMENT_SUCCESS'),
                    });
                }
            } catch (error) {
                MakeToast({
                    variant: 'warning',
                    title: this.$t('TOAST.TITLE.WARNING'),
                    content: error || this.$t('TOAST.CONTENT.DEPARTMENT_MANAGEMENT.UPDATE_DEPARTMENT_FAILED'),
                });

                this.editDialog = false;
            }
        },

        async doRemoveDepartment(department_id) {
            const URL = `${urlAPI.apiDeleteDepartment}${department_id}`;

            try {
                const response = await deleteDepartment(URL);
                if (response.code === 200) {
                    this.deleteDialog = false;

                    this.getDepartmentManagementData();

                    MakeToast({
                        variant: 'success',
                        title: this.$t('TOAST.TITLE.SUCCESS'),
                        content: this.$t('TOAST.CONTENT.DEPARTMENT_MANAGEMENT.DELETE_DEPARTMENT_SUCCESS'),
                    });
                }
            } catch (error) {
                MakeToast({
                    variant: 'warning',
                    title: this.$t('TOAST.TITLE.WARNING'),
                    content: error || this.$t('TOAST.CONTENT.DEPARTMENT_MANAGEMENT.DELETE_DEPARTMENT_FAILED'),
                });

                this.deleteDialog = false;
            }
        },
    },
};
</script>

<style lang="scss" scoped>
  @import "@/scss/variables.scss";

  .department-management {

    ::v-deep .v-dialog {
      overflow-y: visible;
    }

    .department-management-list-table {
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
    .department-management {
      max-height: 100%;
    }
  }
</style>
