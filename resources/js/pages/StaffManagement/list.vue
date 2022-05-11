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
										<v-col cols="6" class="text-center">
											<v-icon small class="text-primary" @click="editDialog = true, getSpecificUser(item.id)">fas fa-edit</v-icon>
										</v-col>

										<v-col cols="6" class="text-left">
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

				<!-- Register Dialog -->
				<v-dialog v-model="registerDialog" max-width="500" persistent scrollable>
					<v-card max-height="600">
						<v-btn elevation="3" block tile class="mb-3 cornflower">
							<span>{{ $t('STAFF_MANAGEMENT.NEW_STAFF') }}</span>
						</v-btn>

						<v-card-text>
							<v-row class="mt-1">
								<v-col cols="12">
									<vAvatarInput
										v-model="user.avatar"
										:default-src="defaultAvatar"
									/>
								</v-col>

								<v-col cols="12">
									<v-text-field
										v-model="user.user_name"
										:label="$t('STAFF_MANAGEMENT.USER_NAME')"
										outlined
									/>
								</v-col>

								<v-col cols="12">
									<v-text-field
										v-model="user.user_code"
										:label="$t('STAFF_MANAGEMENT.USER_CODE')"
										outlined
										type="number"
										onkeydown="javascript: return event.keyCode === 8 || event.keyCode === 46 ? true : !isNaN(Number(event.key))"
									/>
								</v-col>

								<v-col cols="12">
									<v-text-field
										v-model="user.password"
										:label="$t('STAFF_MANAGEMENT.PASSWORD')"
										outlined
										type="password"
									/>
								</v-col>

								<v-col cols="12">
									<v-text-field
										v-model="user.email"
										:label="$t('STAFF_MANAGEMENT.EMAIL')"
										:rules="[rules.email]"
										outlined
									/>
								</v-col>

								<v-col cols="12">
									<v-dialog
										v-model="dialogSelectDOB"
										:scrollable="false"
										max-width="350"
									>
										<template #activator="{ on, attrs }">
											<v-text-field
												v-model="user.dob"
												:label="$t('STAFF_MANAGEMENT.DOB')"
												readonly
												outlined
												v-bind="attrs"
												v-on="on"
											/>
										</template>

										<v-date-picker
											v-model="user.dob"
											show-current
											:locale="language"
											elevation="24"
											width="350"
											color="green lighten-1"
											@input="dialogSelectDOB = false"
										/>
									</v-dialog>
								</v-col>

								<v-col cols="12">
									<v-textarea
										v-model="user.address"
										:label="$t('STAFF_MANAGEMENT.ADDRESS')"
										outlined
										no-resize
									/>
								</v-col>

								<v-col cols="12">
									<v-text-field
										v-model="user.phone_number"
										:label="$t('STAFF_MANAGEMENT.PHONE_NUMBER')"
										outlined
										onkeydown="javascript: return event.keyCode === 8 || event.keyCode === 46 ? true : !isNaN(Number(event.key))"
									/>
								</v-col>

								<v-col cols="12">
									<v-select
										v-model="user.is_retired"
										:items="RetireList"
										:label="$t('STAFF_MANAGEMENT.IS_RETIRED.TITLE')"
										:item-disabled="item => item.value === null"
										outlined
									/>
								</v-col>

								<v-col cols="6">
									<v-select
										v-model="user.role_id"
										:items="RoleList"
										:item-disabled="item => role !== 'admin' ? item.value === 'admin' : '' || item.value === null"
										:label="$t('STAFF_MANAGEMENT.ROLE')"
										outlined
									/>
								</v-col>

								<v-col cols="6">
									<v-select
										v-model="user.department_id"
										:items="DepartmentList"
										:item-disabled="item => item.value === null"
										:label="$t('STAFF_MANAGEMENT.DEPARTMENT')"
										outlined
									/>
								</v-col>

								<v-col cols="12">
									<v-select v-model="user.position_id" :items="PositionList" outlined :label="$t('STAFF_MANAGEMENT.POSITION')" :item-disabled="item => item.value === null">
										<template #prepend-item>
											<v-list-item>
												<v-list-item-content>
													<v-text-field v-model="search_position" :placeholder="$t('BUTTON.SEARCH')" @input="searchPositions()" />
												</v-list-item-content>
											</v-list-item>
											<v-divider class="mt-1" />
										</template>
									</v-select>
								</v-col>

								<v-col cols="12">
									<v-select
										v-model="user.contract_id"
										:item-disabled="item => item.value === null"
										:items="ContractType"
										:label="$t('STAFF_MANAGEMENT.CONTRACT')"
										outlined
									/>
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
									<v-btn class="primary-btn" @click="doRegisterUser()">
										<v-icon left>fas fa-plus-circle</v-icon>
										<span>{{ $t('BUTTON.REGISTER') }}</span>
									</v-btn>
								</v-col>
							</v-row>
						</v-card-actions>
					</v-card>
				</v-dialog>

				<!-- Edit Dialog -->
				<v-dialog v-model="editDialog" max-width="500" persistent scrollable>
					<v-card max-height="600">
						<v-btn elevation="3" block tile class="mb-3 cornflower">
							<span>{{ $t('STAFF_MANAGEMENT.EDIT_STAFF') }}</span>
						</v-btn>

						<v-card-text>
							<v-row class="mt-1">
								<v-col cols="12">
									<vAvatarInput
										v-model="user.avatar"
										:default-src="defaultAvatar"
									/>
								</v-col>

								<v-col cols="12">
									<v-text-field
										v-model="user.user_name"
										:label="$t('STAFF_MANAGEMENT.USER_NAME')"
										outlined
									/>
								</v-col>

								<v-col cols="12">
									<v-text-field
										v-model="user.user_code"
										:label="$t('STAFF_MANAGEMENT.USER_CODE')"
										:disabled="role === 'staff' ? true : false"
										outlined
										type="number"
									/>
								</v-col>

								<v-col cols="12">
									<v-text-field
										v-model="user.email"
										:label="$t('STAFF_MANAGEMENT.EMAIL')"
										outlined
									/>
								</v-col>

								<v-col cols="12">
									<v-dialog
										v-model="dialogSelectDOB"
										:scrollable="false"
										max-width="250"
									>
										<template #activator="{ on, attrs }">
											<v-text-field
												v-model="user.dob"
												:label="$t('STAFF_MANAGEMENT.DOB')"
												readonly
												outlined
												v-bind="attrs"
												v-on="on"
											/>
										</template>

										<v-date-picker
											v-model="user.dob"
											show-current
											:locale="language"
											elevation="24"
											width="250"
											color="green lighten-1"
											@input="dialogSelectDOB = false"
										/>
									</v-dialog>
								</v-col>

								<v-col cols="12">
									<v-textarea
										v-model="user.address"
										:label="$t('STAFF_MANAGEMENT.ADDRESS')"
										outlined
										no-resize
									/>
								</v-col>

								<v-col cols="12">
									<v-text-field
										v-model="user.phone_number"
										:label="$t('STAFF_MANAGEMENT.PHONE_NUMBER')"
										outlined
									/>
								</v-col>

								<v-col cols="12">
									<v-select
										v-model="user.is_retired"
										:items="RetireList"
										:label="$t('STAFF_MANAGEMENT.IS_RETIRED.TITLE')"
										:item-disabled="item => item.value === null"
										outlined
									/>
								</v-col>

								<v-col cols="12">
									<v-select
										v-model="user.role_id"
										:items="RoleList"
										:item-disabled="item => role !== 'admin' ? item.value === 'admin' : '' || item.value === null"
										:label="$t('STAFF_MANAGEMENT.ROLE')"
										outlined
									/>
								</v-col>

								<v-col cols="12">
									<v-select
										v-model="user.department_id"
										:items="DepartmentList"
										:item-disabled="item => item.value === null"
										:label="$t('STAFF_MANAGEMENT.DEPARTMENT')"
										outlined
									/>
								</v-col>

								<v-col cols="12">
									<v-select v-model="user.position_id" :items="PositionList" outlined :label="$t('STAFF_MANAGEMENT.POSITION')" :item-disabled="item => item.value === null">
										<template #prepend-item>
											<v-list-item>
												<v-list-item-content>
													<v-text-field v-model="search_position" :placeholder="$t('BUTTON.SEARCH')" @input="searchPositions()" />
												</v-list-item-content>
											</v-list-item>
											<v-divider class="mt-1" />
										</template>
									</v-select>
								</v-col>

								<v-col cols="12">
									<v-select
										v-model="user.contract_id"
										:item-disabled="item => item.value === null"
										:items="ContractType"
										:label="$t('STAFF_MANAGEMENT.CONTRACT')"
										outlined
									/>
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
									<v-btn class="primary-btn" @click="doUpdateUser(user.id)">
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
							<span>{{ $t('STAFF_MANAGEMENT.DELETE_STAFF') }}</span>
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
									<v-btn class="danger-btn" @click="doRemoveUser(deleting_id)">
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

import { createSchedule } from '@/api/modules/schedule';

import { createTimesheet } from '@/api/modules/timesheet';

import { MakeToast } from '@/utils/MakeToast';

import { convertFromIDToName } from '@/utils/convertFromIdToName';

import { getYMDFromString } from '@/utils/getYMDFromString';

import vAvatarInput from '../../components/atoms/vAvatarInput';

const urlAPI = {
    apiGetAllUser: '/users/list',
    apiGetAllPosition: '/position/list',
    apiGetAllContract: '/contract/list',
    apiGetAllDepartment: '/department/list',
    apiGetOneUser: '/users/detail/',
    apiCreateUser: '/users/create',
    apiUpdateUser: '/users/update/',
    apiDeleteUser: '/users/delete/',
    apiCreateSchedule: '/schedule-management/create',
    apiCreateTimesheet: '/timesheet-management/create',
};

import defaultAvatar from '@/assets/images/defaultAvatar.png';

export default {
    name: 'StaffManagementList',
    components: {
        vAvatarInput,
    },
    data() {
        return {
            overlay: {
                show: false,
                variant: 'light',
                opacity: 1,
                blur: '1rem',
                rounded: 'sm',
            },

            rules: {
                email: value => {
                    const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                    return pattern.test(value) || this.$t('STAFF_MANAGEMENT.EMAIL_FORMAT_ERROR');
                },
            },

            defaultAvatar,

            convertFromIDToName: convertFromIDToName,

            getYMDFromString: getYMDFromString,

            user: {
                user_name: '',
                user_code: '',
                email: '',
                dob: '',
                participated_date: '',
                address: '',
                phone_number: '',
                is_retired: null,
                avatar: '',
                role_id: null,
                department_id: null,
                position_id: null,
                contract_id: null,
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

            PositionList: [
                { value: null, text: this.$t('PLACE_HOLDER.PLEASE_SELECT') },
            ],

            PositionListCopy: [],

            ContractType: [
                { value: null, text: this.$t('PLACE_HOLDER.PLEASE_SELECT') },
            ],

            DepartmentList: [
                { value: null, text: this.$t('PLACE_HOLDER.PLEASE_SELECT') },
            ],

            RoleList: [
                { value: null, text: this.$t('PLACE_HOLDER.PLEASE_SELECT') },
                { value: 1, text: this.$t('ROLE.ADMIN') },
                { value: 2, text: this.$t('ROLE.MANAGER') },
                { value: 3, text: this.$t('ROLE.STAFF') },
            ],

            RetireList: [
                { value: null, text: this.$t('PLACE_HOLDER.PLEASE_SELECT') },
                { value: 1, text: this.$t('STAFF_MANAGEMENT.IS_RETIRED.RETIRED') },
                { value: 2, text: this.$t('STAFF_MANAGEMENT.IS_RETIRED.WORKING') },
            ],

            search: '',

            search_position: '',

            registerDialog: false,

            detailDialog: false,

            editDialog: false,

            deleteDialog: false,
            deleting_id: '',

            dialogSelectDOB: false,

            language: this.$store.getters.language,

            role: this.$store.getters.roles[0],
        };
    },
    created() {
        this.getStaffManagementData();

        this.$bus.on('avatarChange', (file) => {
            this.user.avatar = file.name;
        });
    },
    destroyed() {
        this.$bus.off('avatarChange');
    },
    methods: {
        async getStaffManagementData() {
            await this.getUserList();
            await this.getPositionList();
            await this.getContractType();
            await this.getDepartmentList();
        },

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

                    this.PositionListCopy = [...this.PositionList];
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
                is_retired: null,
                avatar: '',
                role_id: null,
                department_id: null,
                position_id: null,
                contract_id: null,
            };

            const URL = `${urlAPI.apiGetOneUser}${user_id}`;

            try {
                const response = await getOneUser(URL);

                if (response.code === 200) {
                    this.user = response.data;
                    this.user.role_id = response.data.roles[0].pivot.role_id;
                    this.user.dob = getYMDFromString(response.data.dob);
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
                is_retired: null,
                avatar: '',
                role_id: null,
                department_id: null,
                position_id: null,
                contract_id: null,
            };

            this.registerDialog = true;
        },

        async doRegisterUser() {
            try {
                this.user.participated_date = new Date().toISOString().split('T')[0];
                const response = await createUser(urlAPI.apiCreateUser, this.user);

                if (response.code === 200) {
                    this.registerDialog = false;

                    await this.getStaffManagementData();

                    MakeToast({
                        variant: 'success',
                        title: this.$t('TOAST.TITLE.SUCCESS'),
                        content: this.$t('TOAST.CONTENT.STAFF_MANAGEMENT.CREATE_STAFF_SUCCESS'),
                    });

                    const SCHEDULE_DATA = {
                        user_id: null,
                        user_code: this.user.user_code,
                        user_name: this.user.user_name,
                        contract_type: this.user.contract_id,
                        department_id: this.user.department_id,
                        position_id: this.user.position_id,
                        role_id: this.user.role_id,
                        schedules: [],
                    };

                    const TIMESHEET_DATA = {
                        user_id: null,
                        user_code: this.user.user_code,
                        user_name: this.user.user_name,
                        role_id: this.user.role_id,
                        department_id: this.user.department_id,
                        position_id: this.user.position_id,
                        contract_type: this.user.contract_id,
                        timesheet: [],
                        schedule: [],
                    };

                    await createSchedule(urlAPI.apiCreateSchedule, SCHEDULE_DATA);

                    await createTimesheet(urlAPI.apiCreateTimesheet, TIMESHEET_DATA);
                }
            } catch (error) {
                MakeToast({
                    variant: 'warning',
                    title: this.$t('TOAST.TITLE.WARNING'),
                    content: error || this.$t('TOAST.CONTENT.STAFF_MANAGEMENT.CREATE_STAFF_FAILED'),
                });

                this.registerDialog = false;
            }
        },

        async doUpdateUser(user_id) {
            const URL = `${urlAPI.apiUpdateUser}${user_id}`;

            try {
                delete this.user.participated_date;
                const response = await updateUser(URL, this.user);

                if (response.code === 200) {
                    this.editDialog = false;

                    await this.getStaffManagementData();

                    MakeToast({
                        variant: 'success',
                        title: this.$t('TOAST.TITLE.SUCCESS'),
                        content: this.$t('TOAST.CONTENT.STAFF_MANAGEMENT.UPDATE_STAFF_SUCCESS'),
                    });
                }
            } catch (error) {
                MakeToast({
                    variant: 'warning',
                    title: this.$t('TOAST.TITLE.WARNING'),
                    content: error || this.$t('TOAST.CONTENT.STAFF_MANAGEMENT.UPDATE_STAFF_FAILED'),
                });

                this.editDialog = false;
            }
        },

        async doRemoveUser(user_id) {
            const URL = `${urlAPI.apiDeleteUser}${user_id}`;

            try {
                const response = await deleteUser(URL);
                if (response.code === 200) {
                    this.deleteDialog = false;

                    this.getStaffManagementData();

                    MakeToast({
                        variant: 'success',
                        title: this.$t('TOAST.TITLE.SUCCESS'),
                        content: this.$t('TOAST.CONTENT.STAFF_MANAGEMENT.DELETE_STAFF_SUCCESS'),
                    });
                }
            } catch (error) {
                MakeToast({
                    variant: 'warning',
                    title: this.$t('TOAST.TITLE.WARNING'),
                    content: error || this.$t('TOAST.CONTENT.STAFF_MANAGEMENT.DELETE_STAFF_FAILED'),
                });

                this.deleteDialog = false;
            }
        },

        searchPositions() {
            if (!this.search_position) {
                this.PositionList = this.PositionListCopy;
            }

            this.PositionList = this.PositionListCopy.filter((position) => {
                return position.text.toLowerCase().indexOf(this.search_position.toLowerCase()) > -1;
            });
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
