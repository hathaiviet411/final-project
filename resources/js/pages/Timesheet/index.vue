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
								item-key="task_name"
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
									<span>Total Salary: {{ Timesheet.total_salary }}</span>
								</b-col>

								<b-col cols="12">
									<span>Deduction: {{ Timesheet.deduction }}</span>
								</b-col>

								<b-col cols="12">
									<span>Deduction Reason: {{ Timesheet.deduction_reason }}</span>
								</b-col>

								<b-col cols="12">
									<span>Insurance Fee: {{ Timesheet.insurance_fee }}</span>
								</b-col>

								<b-col cols="12">
									<span>PIT (Personal Income Tax): {{ Timesheet.personal_income_tax }}</span>
								</b-col>

								<b-col cols="12">
									<span :class="[Timesheet.payroll === 'Approved' ? 'text-danger' : 'text-success', 'font-weight-bold']">Payroll Status: {{ Timesheet.payroll_status }}</span>
								</b-col>

								<b-col cols="12">
									<span>Final Amount: {{ Timesheet.final_salary }}</span>
								</b-col>
							</b-row>

							<b-row v-for="(day, index) in DetailSchedule" :key="index">
								<b-col cols="12">
									<v-btn block color="#79018C" class="text-light font-weight-bold">
										<span>{{ day.date }}</span>
									</v-btn>

									<div v-for="(item, itemIndex) in day.tasks" :key="itemIndex" class="list-task">
										<b-row style="border-top: 1px solid #000000;" class="mt-3">
											<b-col cols="12" class="text-left">
												<v-btn color="#EDEDED" class="text-dark font-weight-bold">
													<span>{{ `Task ${itemIndex + 1}` }}</span>
												</v-btn>
											</b-col>

											<b-col cols="4">
												<span>Building: {{ item.building }}</span>
											</b-col>

											<b-col cols="4">
												<span>Room: {{ item.room }}</span>
											</b-col>

											<b-col cols="4">
												<span>Level: {{ item.level }}</span>
											</b-col>

											<b-col cols="4">
												<span>Task Name: {{ item.task_name }}</span>
											</b-col>

											<b-col cols="4">
												<span>Start Time: {{ item.start_time }}</span>
											</b-col>

											<b-col cols="4">
												<span>End Time: {{ item.end_time }}</span>
											</b-col>
										</b-row>
									</div>
								</b-col>
							</b-row>
						</v-card-text>

						<v-card-actions>
							<v-row>
								<v-col cols="12" class="text-center">
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
                { text: this.$t('STAFF_MANAGEMENT.ROLE'), sortable: false, value: 'role_name' },
                { text: this.$t('STAFF_MANAGEMENT.DEPARTMENT'), sortable: false, value: 'department_id' },
                { text: this.$t('STAFF_MANAGEMENT.POSITION'), sortable: false, value: 'position_id' },
                { text: this.$t('STAFF_MANAGEMENT.CONTRACT'), sortable: false, value: 'contract_id' },
                { text: this.$t('BUTTON.ACTIONS'), sortable: false, value: 'actions' },
            ],

            items: [
                {
                    id: 1,
                    user_name: 'Hà Thái Việt',
                    user_code: '04112000',
                    role_name: 'Staff',
                    department_id: 'Ban Quản Lý',
                    position_id: 'Quản Lý',
                    contract_id: 'Full Time',
                },
            ],

            search: '',

            detailTimesheetDialog: '',

            Timesheet: {
                date: '2020-01-01',
                total_salary: '7.500.000',
                deduction: '500.000',
                deduction_reason: 'Working Late',
                insurance_fee: '213.000',
                personal_income_tax: '124.000',
                payroll_status: 'Approved',
                final_salary: '6,663,000',
            },

            DetailSchedule: [
                {
                    date: '2020-01-01',
                    tasks: [
                        {
                            id: 1,
                            task_name: 'Nhập liệu',
                            date: '2020-01-01',
                            start_time: '09:00',
                            end_time: '18:30',
                            building: 'Tòa A',
                            level: '2',
                            room: '209',
                        },
                        {
                            id: 2,
                            task_name: 'Dọn vệ sinh',
                            date: '2020-01-01',
                            start_time: '09:00',
                            end_time: '18:30',
                            building: 'Tòa D',
                            level: '6',
                            room: '621',
                        },
                    ],
                },
                {
                    date: '2020-01-02',
                    tasks: [
                        {
                            id: 1,
                            task_name: 'Nhập liệu',
                            date: '2020-01-01',
                            start_time: '09:00',
                            end_time: '18:30',
                            building: 'Tòa A',
                            level: '2',
                            room: '209',
                        },
                        {
                            id: 2,
                            task_name: 'Dọn vệ sinh',
                            date: '2020-01-01',
                            start_time: '09:00',
                            end_time: '18:30',
                            building: 'Tòa D',
                            level: '6',
                            room: '621',
                        },
                    ],
                },
                {
                    date: '2020-01-03',
                    tasks: [
                        {
                            id: 1,
                            task_name: 'Nhập liệu',
                            date: '2020-01-01',
                            start_time: '09:00',
                            end_time: '18:30',
                            building: 'Tòa A',
                            level: '2',
                            room: '209',
                        },
                        {
                            id: 2,
                            task_name: 'Dọn vệ sinh',
                            date: '2020-01-01',
                            start_time: '09:00',
                            end_time: '18:30',
                            building: 'Tòa D',
                            level: '6',
                            room: '621',
                        },
                    ],
                },
                {
                    date: '2020-01-04',
                    tasks: [
                        {
                            id: 1,
                            task_name: 'Nhập liệu',
                            date: '2020-01-01',
                            start_time: '09:00',
                            end_time: '18:30',
                            building: 'Tòa A',
                            level: '2',
                            room: '209',
                        },
                        {
                            id: 2,
                            task_name: 'Dọn vệ sinh',
                            date: '2020-01-01',
                            start_time: '09:00',
                            end_time: '18:30',
                            building: 'Tòa D',
                            level: '6',
                            room: '621',
                        },
                    ],
                },
            ],
        };
    },
    created() {
        this.getTimesheet();
    },
    methods: {
        getTimesheet() {
            console.log('Get Timesheet');
        },

        openDetailTimesheetDialog(user_id) {
            this.detailTimesheetDialog = true;
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
