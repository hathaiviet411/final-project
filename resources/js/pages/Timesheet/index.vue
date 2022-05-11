<template>
	<div class="timesheet-management">
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
									<b-col lg="12" md="12" sm="12" class="text-center">
										<v-text-field
											v-model="search"
											append-icon="mdi-magnify"
											:label="$t('BUTTON.SEARCH')"
											single-line
											hide-details
										/>
									</b-col>
								</b-row>
							</v-card-title>

							<v-data-table
								class="timesheet-management-list-table mt-3"
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
								<template #[`item.role_id`]="{ item }">
									<span v-if="item.role_id === 1">{{ $t('ROLE.ADMIN') }}</span>
									<span v-else-if="item.role_id === 2">{{ $t('ROLE.MANAGER') }}</span>
									<span v-else-if="item.role_id === 3">{{ $t('ROLE.STAFF') }}</span>
								</template>

								<template #[`item.department_id`]="{ item }">
									<span>{{ convertFromIDToName(item.department_id, DepartmentList) }}</span>
								</template>

								<template #[`item.position_id`]="{ item }">
									<span>{{ convertFromIDToName(item.position_id, PositionList) }}</span>
								</template>

								<template #[`item.contract_type`]="{ item }">
									<span>{{ convertFromIDToName(item.contract_type, ContractType) }}</span>
								</template>

								<template #[`item.actions`]="{ item }">
									<v-btn block class="bg-success text-light font-weight-bold" @click="openDetailTimesheetDialog(item.id)">
										<span>{{ $t('BUTTON.DETAIL') }}</span>
									</v-btn>
								</template>
							</v-data-table>
						</v-card>
					</v-col>
				</v-row>

				<v-dialog v-model="detailTimesheetDialog" max-width="500" persistent scrollable>
					<v-card max-height="600">
						<v-btn elevation="3" block tile class="mb-3 cornflower">
							<span>{{ $t('TIMESHEET_MANAGEMENT.DETAIL_TIMESHEET') }}</span>
						</v-btn>

						<v-card-text>

							<b-row>
								<b-col cols="12">
									<span>Total Salary: {{ timesheet.total_salary }}</span>
								</b-col>

								<b-col cols="12">
									<span>Deduction: {{ timesheet.deduction }}</span>
								</b-col>

								<b-col cols="12">
									<span>Deduction Reason: {{ timesheet.deduction_reason }}</span>
								</b-col>

								<b-col cols="12">
									<span>Insurance Fee: {{ timesheet.insurance_fee }}</span>
								</b-col>

								<b-col cols="12">
									<span>PIT (Personal Income Tax): {{ timesheet.personal_income_tax }}</span>
								</b-col>

								<b-col cols="12">
									<span :class="[timesheet.payroll === 'Approved' ? 'text-danger' : 'text-success', 'font-weight-bold']">Payroll Status: {{ timesheet.payroll_status }}</span>
								</b-col>

								<b-col cols="12">
									<span>Final Amount: {{ timesheet.final_salary }}</span>
								</b-col>
							</b-row>

							<b-row v-for="(item, index) in DetailSchedule" :key="index">
								<b-col cols="12">
									<b-row style="border-top: 1px solid #000000;" class="mt-3">
										<b-col cols="12" class="text-left">
											<i class="fas fa-tasks mr-3" />
											<span class="font-weight-bold">{{ `TASK ${index + 1}` }}</span>
										</b-col>

										<b-col lg="4" md="4" sm="12">
											<span>{{ $t('TASK_MANAGEMENT.TASK_NAME') }}:</span>
											<span>{{ convertFromIDToName(item.task_name, Tasks) }}</span>
										</b-col>

										<b-col lg="4" md="4" sm="12">
											<span>{{ $t('SCHEDULE_MANAGEMENT.DATE') }}:</span>
											<span>{{ item.date }}</span>
										</b-col>

										<b-col lg="4" md="4" sm="12">
											<span>{{ $t('SCHEDULE_MANAGEMENT.START_TIME') }}:</span>
											<span>{{ item.start_time }}</span>
										</b-col>

										<b-col lg="4" md="4" sm="12">
											<span>{{ $t('SCHEDULE_MANAGEMENT.END_TIME') }}:</span>
											<span>{{ item.end_time }}</span>
										</b-col>

										<b-col lg="4" md="4" sm="12">
											<span>{{ $t('ROOM_MANAGEMENT.BUILDING') }}:</span>
											<span>{{ convertFromIDToName(item.building, Buildings) }}</span>
										</b-col>

										<b-col lg="4" md="4" sm="12">
											<span>{{ $t('ROOM_MANAGEMENT.LEVEL') }}:</span>
											<span>{{ item.level }}</span>
										</b-col>

										<b-col lg="4" md="4" sm="12">
											<span>{{ $t('ROOM_MANAGEMENT.ROOM_NUMBER') }}:</span>
											<span>{{ item.room }}</span>
										</b-col>

										<b-col lg="4" md="4" sm="12">
											<span>{{ $t('SCHEDULE_MANAGEMENT.TASK_STATUS.TITLE') }}:</span>
											<span>{{ convertFromIDToName(item.task_status, TaskStatus) }}</span>
										</b-col>

										<b-col lg="4" md="4" sm="12">
											<span>{{ $t('SCHEDULE_MANAGEMENT.APPROVE_STATUS.TITLE') }}:</span>
											<span>{{ convertFromIDToName(item.approve_status, ApproveStatus) }}</span>
										</b-col>

										<b-col lg="4" md="4" sm="12">
											<span>{{ $t('SCHEDULE_MANAGEMENT.SPENT_TIME') }}:</span>
											<span>{{ item.spent_time }}</span>
										</b-col>

										<b-col lg="4" md="4" sm="12">
											<span>{{ $t('SCHEDULE_MANAGEMENT.REMARK') }}:</span>
											<span>{{ item.remark }}</span>
										</b-col>
									</b-row>
								</b-col>
							</b-row>
						</v-card-text>

						<v-card-actions>
							<v-row>
								<v-col cols="12" class="text-left">
									<v-btn class="danger-btn" @click="detailTimesheetDialog = false">
										<v-icon left>mdi-close-box</v-icon>
										<span>{{ $t('BUTTON.CANCEL') }}</span>
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
import { getAllTimesheet, getOneTimesheet } from '@/api/modules/timesheet';

import { getAllPosition } from '@/api/modules/position';

import { getAllContract } from '@/api/modules/contract';

import { getAllDepartment } from '@/api/modules/department';

import { getAllBuilding } from '@/api/modules/building';

import { getAllTask } from '@/api/modules/task';

// import { MakeToast } from '@/utils/MakeToast';

import { convertFromIDToName } from '@/utils/convertFromIdToName';

const urlAPI = {
    apiGetAllTimesheet: '/timesheet-management/list',
    apiGetOneTimesheet: '/timesheet-management/detail',
    apiGetAllPosition: '/position/list',
    apiGetAllContract: '/contract/list',
    apiGetAllDepartment: '/department/list',
    apiGetAllBuilding: '/building/list',
    apiGetAllTask: '/task/all',
};

export default {
    name: 'TimesheetManagement',
    data() {
        return {
            overlay: {
                show: false,
                variant: 'light',
                opacity: 1,
                blur: '1rem',
                rounded: 'sm',
            },

            headers: [
                { text: this.$t('STAFF_MANAGEMENT.USER_NAME'), sortable: false, value: 'user_name' },
                { text: this.$t('STAFF_MANAGEMENT.USER_CODE'), sortable: false, value: 'user_code' },
                { text: this.$t('STAFF_MANAGEMENT.ROLE'), sortable: false, value: 'role_id' },
                { text: this.$t('STAFF_MANAGEMENT.DEPARTMENT'), sortable: false, value: 'department_id' },
                { text: this.$t('STAFF_MANAGEMENT.POSITION'), sortable: false, value: 'position_id' },
                { text: this.$t('STAFF_MANAGEMENT.CONTRACT'), sortable: false, value: 'contract_type' },
                { text: this.$t('BUTTON.ACTIONS'), sortable: false, value: 'actions' },
            ],

            items: [],

            PositionList: [
                { value: null, text: this.$t('PLACE_HOLDER.PLEASE_SELECT') },
            ],

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

            Tasks: [
                { value: null, text: this.$t('PLACE_HOLDER.PLEASE_SELECT') },
            ],

            Buildings: [
                { value: null, text: this.$t('PLACE_HOLDER.PLEASE_SELECT') },
            ],

            Rooms: [
                { value: null, text: this.$t('PLACE_HOLDER.PLEASE_SELECT') },
            ],

            TaskStatus: [
                { value: 1, text: this.$t('SCHEDULE_MANAGEMENT.TASK_STATUS.PENDING') },
                { value: 2, text: this.$t('SCHEDULE_MANAGEMENT.TASK_STATUS.IN_PROGRESS') },
                { value: 3, text: this.$t('SCHEDULE_MANAGEMENT.TASK_STATUS.COMPLETED') },
                { value: 4, text: this.$t('SCHEDULE_MANAGEMENT.TASK_STATUS.FEEDBACK') },
                { value: 5, text: this.$t('SCHEDULE_MANAGEMENT.TASK_STATUS.ABORTED') },
            ],

            ApproveStatus: [
                { value: 1, text: this.$t('SCHEDULE_MANAGEMENT.TASK_STATUS.PENDING') },
                { value: 2, text: this.$t('SCHEDULE_MANAGEMENT.APPROVE_STATUS.APPROVED') },
                { value: 3, text: this.$t('SCHEDULE_MANAGEMENT.APPROVE_STATUS.REFUSED') },
            ],

            convertFromIDToName: convertFromIDToName,

            search: '',

            detailTimesheetDialog: '',

            timesheet: {
                date: '2020-01-01',
                total_salary: '7.500.000',
                deduction: '500.000',
                deduction_reason: 'Working Late',
                insurance_fee: '213.000',
                personal_income_tax: '124.000',
                payroll_status: 'Approved',
                final_salary: '6,663,000',
            },

            DetailSchedule: [],
        };
    },
    created() {
        this.getTimesheetManagementData();
    },
    methods: {
        async getTimesheetManagementData() {
            this.overlay.show = true;
            await this.getBuildingList();
            await this.getTimesheet();
            await this.getPositionList();
            await this.getContractType();
            await this.getDepartmentList();
            await this.getTaskList();
            this.overlay.show = false;
        },

        async getTimesheet() {
            try {
                const response = await getAllTimesheet(urlAPI.apiGetAllTimesheet);

                if (response.code === 200) {
                    this.items = response.data;
                }
            } catch (error) {
                console.log(error);
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

        async getBuildingList() {
            try {
                const response = await getAllBuilding(urlAPI.apiGetAllBuilding);

                if (response.code === 200) {
                    for (let i = 0; i < response.data.length; i++) {
                        this.Buildings.push({
                            text: response.data[i].building_name,
                            value: response.data[i].id,
                        });
                    }
                }
            } catch (error) {
                console.log(error);
            }
        },

        async getTaskList() {
            try {
                const response = await getAllTask(urlAPI.apiGetAllTask);

                if (response.code === 200) {
                    for (let i = 0; i < response.data.length; i++) {
                        this.Tasks.push({
                            text: response.data[i].task_name,
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

        async getDetaiLTimesheetInformation(id) {
            try {
                const URL = `${urlAPI.apiGetOneTimesheet}/${id}`;

                const response = await getOneTimesheet(URL);

                if (response.code === 200) {
                    this.DetailSchedule = response.data.schedule;
                    console.log(this.DetailSchedule);
                }
            } catch (error) {
                console.log(error);
            }
        },

        openDetailTimesheetDialog(user_id) {
            this.detailTimesheetDialog = true;

            this.getDetaiLTimesheetInformation(user_id);
        },
    },
};
</script>

<style lang="scss" scoped>
  @import "@/scss/variables.scss";

  .timesheet-management {

    ::v-deep .v-dialog {
      overflow-y: visible;
    }

    .timesheet-management-list-table {
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
    .timesheet-management {
      max-height: 100%;
    }
  }
</style>
