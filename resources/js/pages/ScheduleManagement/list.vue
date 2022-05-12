<template>
	<div class="schedule-management">
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
									<b-col v-if="role !== 'staff'" cols="12">
										<vHeaderFilter class="mt-3 filter-area">
											<template #zone-filter>
												<b-row>
													<b-col cols="12">
														<span style="font-size: 16px !important;" class="text-underline cursor-pointer text-bold" @click="doClearFilter()">{{ $t('BUTTON.CLEAR_ALL') }}</span>
													</b-col>
												</b-row>

												<b-row>
													<!-- Department -->
													<b-col cols="12" class="mt-1">
														<vSelectGroup
															v-model="filter.department.value"
															:text-prepend="$t('SCHEDULE_MANAGEMENT.FILTER.DEPARTMENT')"
															:is-check="filter.department.status"
															:data-options="departments"
															@isChecked="getIsCheckFilterDepartment"
														/>
													</b-col>

													<!-- Position -->
													<b-col cols="12" class="mt-1">
														<vSelectGroup
															v-model="filter.position.value"
															:text-prepend="$t('SCHEDULE_MANAGEMENT.FILTER.POSITION')"
															:is-check="filter.position.status"
															:data-options="positions"
															@isChecked="getIsCheckFilterPosition"
														/>
													</b-col>

													<!-- Contract Type -->
													<b-col cols="12" class="mt-1">
														<vSelectGroup
															v-model="filter.contract_type.value"
															:text-prepend="$t('SCHEDULE_MANAGEMENT.FILTER.CONTRACT_TYPE')"
															:is-check="filter.contract_type.status"
															:data-options="contract_type"
															@isChecked="getIsCheckFilterContractType"
														/>
													</b-col>
												</b-row>

												<b-row class="my-3">
													<b-col cols="12">
														<v-btn class="primary-btn" @click="doApplyFilter()">
															<i class="fas fa-filter mr-3 text-white" />
															<span>{{ $t('BUTTON.APPLY') }}</span>
														</v-btn>
													</b-col>
												</b-row>
											</template>
										</vHeaderFilter>
									</b-col>

									<b-col v-if="role !== 'staff'" cols="12">
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

							<v-card-text>
								<v-data-table
									class="schedule-management-list-table"
									:headers="headers"
									:items="ScheduleList"
									:search="search"
									:footer-props="{
										itemsPerPageText: $t('PAGINATION.DISPLAY_PER_PAGE'),
										itemsPerPageAllText: $t('PAGINATION.ALL'),
										itemsPerPageOption: [10, 20, 50, 100, -1]
									}"
								>
									<template #[`item.schedule_detail_action`]="{ item }">
										<v-btn fab dark small color="#3F0071" @click="openScheduleDetailDialog(item.id)">
											<v-icon small>fas fa-calendar-day</v-icon>
										</v-btn>
									</template>

									<template #[`item.assign_new_task_action`]="{ item }">
										<v-btn v-if="role !== 'staff'" fab dark small color="#1E2AA5" @click="openAssignNewTaskDialog(item.id)">
											<v-icon small>fas fa-layer-plus</v-icon>
										</v-btn>
									</template>

									<template #[`item.department_id`]="{ item }">
										<span>{{ convertFromIDToName(item.department_id, departments) }}</span>
									</template>

									<template #[`item.position_id`]="{ item }">
										<span>{{ convertFromIDToName(item.position_id, positions) }}</span>
									</template>

									<template #[`item.contract_type`]="{ item }">
										<span>{{ convertFromIDToName(item.contract_type, contract_type) }}</span>
									</template>

									<template #[`item.schedules`]="{ item }">
										<span v-if="item.schedules.length === 0" class="text-danger">{{ $t('SCHEDULE_MANAGEMENT.ASSIGN_STATUS.UNASSIGNED') }}</span>
										<span v-else class="text-success">{{ $t('SCHEDULE_MANAGEMENT.ASSIGN_STATUS.ASSIGNED') }}</span>
									</template>
								</v-data-table>
							</v-card-text>
						</v-card>
					</v-col>
				</v-row>

				<!-- Register Dialog -->
				<v-dialog v-model="assignNewTaskDialog" max-width="800" scrollable persistent>
					<v-card max-height="620">
						<v-btn elevation="3" block tile class="mb-3 cornflower">
							<span>{{ $t('SCHEDULE_MANAGEMENT.NEW_SCHEDULE') }}</span>
						</v-btn>

						<v-card-text>
							<span class="text-bold h6">{{ $t('SCHEDULE_MANAGEMENT.USER_INFORMATION') }}</span>

							<v-divider />

							<b-row>
								<b-col lg="6" md="12" sm="12">
									<v-text-field
										v-model="schedule.user.user_name"
										:label="$t('SCHEDULE_MANAGEMENT.USER_NAME')"
										outlined
										disabled
									/>
								</b-col>

								<b-col lg="6" md="12" sm="12">
									<v-select
										v-model="schedule.user.role"
										:label="$t('SCHEDULE_MANAGEMENT.ROLE')"
										:items="roles"
										outlined
										disabled
									/>
								</b-col>
							</b-row>

							<b-row>
								<b-col lg="6" md="12" sm="12">
									<v-select
										v-model="schedule.user.department"
										:label="$t('SCHEDULE_MANAGEMENT.DEPARTMENT')"
										:items="departments"
										outlined
										disabled
									/>
								</b-col>

								<b-col lg="6" md="12" sm="12">
									<v-select
										v-model="schedule.user.position"
										:label="$t('SCHEDULE_MANAGEMENT.POSITION')"
										:items="positions"
										outlined
										disabled
									/>
								</b-col>
							</b-row>

							<b-row>
								<b-col cols="12">
									<v-select
										v-model="schedule.user.contract_type"
										:label="$t('SCHEDULE_MANAGEMENT.CONTRACT_TYPE')"
										:items="contract_type"
										outlined
										disabled
									/>
								</b-col>
							</b-row>

							<span class="text-bold h6">{{ $t('SCHEDULE_MANAGEMENT.WORKING_PLACE_INFORMATION') }}</span>

							<v-divider />

							<!-- Work Place Information -->
							<b-row>
								<b-col lg="4" md="12" sm="12">
									<v-select
										v-model="schedule.work_place.building"
										:label="$t('SCHEDULE_MANAGEMENT.BUILDING')"
										:items="buildings"
										outlined
										@input="getListRoomByBuilding()"
									/>
								</b-col>

								<b-col lg="4" md="12" sm="12">
									<v-select
										v-model="schedule.work_place.room"
										:label="$t('SCHEDULE_MANAGEMENT.ROOM')"
										:items="rooms"
										outlined
										@input="setLevelByRoomNumber()"
									/>
								</b-col>

								<b-col lg="4" md="12" sm="12">
									<v-text-field
										v-model="schedule.work_place.level"
										:label="$t('SCHEDULE_MANAGEMENT.LEVEL')"
										outlined
										disabled
									/>
								</b-col>
							</b-row>

							<span class="text-bold h6">{{ $t('SCHEDULE_MANAGEMENT.TASK_INFORMATION') }}</span>

							<v-divider />

							<!-- Task Information -->
							<b-row>
								<b-col lg="6" md="12" sm="12">
									<v-select
										v-model="schedule.task.task_name"
										:items="tasks"
										:label="$t('TASK_MANAGEMENT.TASK_NAME')"
										outlined
										@input="getTaskInfo()"
									/>
								</b-col>

								<b-col lg="6">
									<v-dialog
										v-model="dialogSelectDate"
										:scrollable="false"
										max-width="350"
									>
										<template #activator="{ on, attrs }">
											<v-text-field
												v-model="schedule.time.date"
												:label="$t('SCHEDULE_MANAGEMENT.DATE')"
												readonly
												outlined
												v-bind="attrs"
												v-on="on"
											/>
										</template>

										<v-date-picker
											v-model="schedule.time.date"
											show-current
											:locale="language"
											elevation="24"
											width="350"
											color="green lighten-1"
											@input="dialogSelectDate = false"
										/>
									</v-dialog>
								</b-col>

								<b-col lg="6" md="12" sm="12">
									<v-dialog
										ref="dialogSelectStartTime"
										v-model="dialogSelectStartTime"
										:return-value.sync="schedule.time.start_time"
										persistent
										max-width="300"
									>
										<template #activator="{ on, attrs }">
											<v-text-field
												v-model="schedule.time.start_time"
												outlined
												:label="$t('SCHEDULE_MANAGEMENT.START_TIME')"
												prepend-inner-icon="mdi-clock-time-four-outline"
												readonly
												v-bind="attrs"
												v-on="on"
											/>
										</template>

										<v-time-picker
											v-if="dialogSelectStartTime"
											v-model="schedule.time.start_time"
											:max="schedule.time.end_time"
											width="300"
											format="24hr"
											scrollable
											color="green lighten-1"
										>
											<v-row>
												<v-col cols="12" class="text-right">
													<v-btn text @click="dialogSelectStartTime = false">
														<span class="text-danger">{{ $t('BUTTON.CANCEL') }}</span>
													</v-btn>

													<v-btn text @click="$refs.dialogSelectStartTime.save(schedule.time.start_time)">
														<span class="text-primary">{{ $t('BUTTON.SAVE') }}</span>
													</v-btn>
												</v-col>
											</v-row>
										</v-time-picker>
									</v-dialog>
								</b-col>

								<b-col lg="6" md="12" sm="12">
									<v-dialog
										ref="dialogSelectEndTime"
										v-model="dialogSelectEndTime"
										:return-value.sync="schedule.time.end_time"
										persistent
										max-width="300"
									>
										<template #activator="{ on, attrs }">
											<v-text-field
												v-model="schedule.time.end_time"
												outlined
												:label="$t('SCHEDULE_MANAGEMENT.END_TIME')"
												prepend-inner-icon="mdi-clock-time-four-outline"
												readonly
												v-bind="attrs"
												v-on="on"
											/>
										</template>

										<v-time-picker
											v-if="dialogSelectEndTime"
											v-model="schedule.time.end_time"
											:min="schedule.time.start_time"
											width="300"
											format="24hr"
											color="green lighten-1"
											scrollable
										>
											<v-row>
												<v-col cols="12" class="text-right">
													<v-btn text @click="dialogSelectEndTime = false">
														<span class="text-danger">{{ $t('BUTTON.CANCEL') }}</span>
													</v-btn>

													<v-btn text @click="$refs.dialogSelectEndTime.save(schedule.time.end_time)">
														<span class="text-primary">{{ $t('BUTTON.SAVE') }}</span>
													</v-btn>
												</v-col>
											</v-row>
										</v-time-picker>
									</v-dialog>
								</b-col>
							</b-row>

							<b-row class="mb-3">
								<b-col lg="2" sm="12" md="12">
									<v-btn class="primary-btn" @click="addNewTaskInAssignedList()">
										<i class="far fa-plus-square mr-3" />
										<span>{{ $t('BUTTON.ASSIGN_TASK') }}</span>
									</v-btn>
								</b-col>
							</b-row>

							<span class="text-bold h6">{{ $t('SCHEDULE_MANAGEMENT.LIST_ASSIGNED_TASK') }}</span>

							<v-divider />

							<!-- List Added Task -->
							<b-row v-for="(task, index) in listAddedTask" :key="index">
								<b-col lg="12" md="12" sm="12" class="text-left">
									<i class="fas fa-tasks mr-3" />
									<span class="font-weight-bold">{{ `TASK ${index + 1}` }}</span>
									<i
										class="far fa-minus-square text-danger float-right"
										@click="removeTaskFromAssignedList(index)"
									/>
								</b-col>

								<v-divider />

								<b-col lg="3" md="4" sm="12">
									<span>{{ $t('TASK_MANAGEMENT.TASK_NAME') }}:</span>
									<span>{{ convertFromIDToName(task.task_name, tasks) }}</span>
								</b-col>

								<b-col lg="3" md="4" sm="12">
									<span>{{ $t('SCHEDULE_MANAGEMENT.DATE') }}:</span>
									<span>{{ task.date }}</span>
								</b-col>

								<b-col lg="3" md="4" sm="12">
									<span>{{ $t('SCHEDULE_MANAGEMENT.START_TIME') }}:</span>
									<span>{{ task.start_time }}</span>
								</b-col>

								<b-col lg="3" md="4" sm="12">
									<span>{{ $t('SCHEDULE_MANAGEMENT.END_TIME') }}:</span>
									<span>{{ task.end_time }}</span>
								</b-col>

								<b-col lg="3" md="4" sm="12">
									<span>{{ $t('ROOM_MANAGEMENT.BUILDING') }}:</span>
									<span>{{ convertFromIDToName(task.building, buildings) }}</span>
								</b-col>

								<b-col lg="3" md="4" sm="12">
									<span>{{ $t('ROOM_MANAGEMENT.LEVEL') }}:</span>
									<span>{{ task.level }}</span>
								</b-col>

								<b-col lg="3" md="4" sm="12">
									<span>{{ $t('ROOM_MANAGEMENT.ROOM_NUMBER') }}:</span>
									<span>{{ task.room }}</span>
								</b-col>

								<b-col lg="3" md="4" sm="12">
									<span>{{ $t('SCHEDULE_MANAGEMENT.TASK_STATUS.TITLE') }}:</span>
									<span>{{ convertFromIDToName(task.task_status, taskStatus) }}</span>
								</b-col>

								<b-col lg="3" md="4" sm="12">
									<span>{{ $t('SCHEDULE_MANAGEMENT.APPROVE_STATUS.TITLE') }}:</span>
									<span>{{ convertFromIDToName(task.approve_status, approveStatus) }}</span>
								</b-col>

								<b-col lg="3" md="4" sm="12">
									<span>{{ $t('SCHEDULE_MANAGEMENT.SPENT_TIME') }}:</span>
									<span>{{ task.spent_time }}</span>
								</b-col>

								<b-col lg="3" md="4" sm="12">
									<span>{{ $t('SCHEDULE_MANAGEMENT.REMARK') }}:</span>
									<span>{{ task.remark }}</span>
								</b-col>
							</b-row>

						</v-card-text>

						<v-card-actions>
							<v-row>
								<v-col cols="6" class="text-center">
									<v-btn class="danger-btn" @click="assignNewTaskDialog = false">
										<v-icon left>mdi-close-box</v-icon>
										<span>{{ $t('BUTTON.CANCEL') }}</span>
									</v-btn>
								</v-col>

								<v-col cols="6" class="text-center">
									<v-btn class="primary-btn" @click="doUpdateSchedule()">
										<v-icon left>fas fa-plus-circle</v-icon>
										<span>{{ $t('BUTTON.REGISTER') }}</span>
									</v-btn>
								</v-col>
							</v-row>
						</v-card-actions>
					</v-card>
				</v-dialog>

				<!-- Detail Schedule Dialog -->
				<v-dialog v-model="detailScheduleDialog" max-width="800" scrollable persistent>
					<v-card max-height="620">
						<v-btn elevation="3" block tile class="mb-3 cornflower">
							<span>{{ $t('SCHEDULE_MANAGEMENT.DETAIL_SCHEDULE') }}</span>
						</v-btn>

						<v-card-text>
							<span class="text-bold h6">{{ $t('SCHEDULE_MANAGEMENT.USER_INFORMATION') }}</span>

							<v-divider />

							<b-row>
								<b-col lg="6" md="12" sm="12">
									<v-text-field
										v-model="schedule.user.user_name"
										:label="$t('SCHEDULE_MANAGEMENT.USER_NAME')"
										outlined
										disabled
									/>
								</b-col>

								<b-col lg="6" md="12" sm="12">
									<v-select
										v-model="schedule.user.role"
										:label="$t('SCHEDULE_MANAGEMENT.ROLE')"
										:items="roles"
										outlined
										disabled
									/>
								</b-col>
							</b-row>

							<b-row>
								<b-col lg="6" md="12" sm="12">
									<v-select
										v-model="schedule.user.department"
										:label="$t('SCHEDULE_MANAGEMENT.DEPARTMENT')"
										:items="departments"
										outlined
										disabled
									/>
								</b-col>

								<b-col lg="6" md="12" sm="12">
									<v-select
										v-model="schedule.user.position"
										:label="$t('SCHEDULE_MANAGEMENT.POSITION')"
										:items="positions"
										outlined
										disabled
									/>
								</b-col>
							</b-row>

							<b-row>
								<b-col cols="12">
									<v-select
										v-model="schedule.user.contract_type"
										:label="$t('SCHEDULE_MANAGEMENT.CONTRACT_TYPE')"
										:items="roles"
										outlined
										disabled
									/>
								</b-col>
							</b-row>

							<span class="text-bold h6">{{ $t('SCHEDULE_MANAGEMENT.LIST_ASSIGNED_TASK') }}</span>

							<v-divider />

							<!-- List Added Task -->
							<b-row v-for="(task, index) in listAddedTask" :key="index">
								<b-col lg="12" md="12" sm="12" class="text-left">
									<i class="fas fa-tasks mr-3" />
									<span class="font-weight-bold">{{ `TASK ${index + 1}` }}</span>
								</b-col>

								<b-col cols="12">
									<v-divider />
								</b-col>

								<b-col lg="3" md="4" sm="6">
									<span>{{ $t('TASK_MANAGEMENT.TASK_NAME') }}</span>
									<span>{{ task.task_name }}</span>
								</b-col>

								<b-col lg="3" md="4" sm="6">
									<span>{{ $t('SCHEDULE_MANAGEMENT.DATE') }}</span>
									<span>{{ task.date }}</span>
								</b-col>

								<b-col lg="3" md="4" sm="6">
									<span>{{ $t('SCHEDULE_MANAGEMENT.START_TIME') }}</span>
									<span>{{ task.start_time }}</span>
								</b-col>

								<b-col lg="3" md="4" sm="6">
									<span>{{ $t('SCHEDULE_MANAGEMENT.END_TIME') }}</span>
									<span>{{ task.end_time }}</span>
								</b-col>

								<b-col lg="3" md="4" sm="6">
									<span>{{ $t('ROOM_MANAGEMENT.BUILDING') }}</span>
									<span>{{ task.building }}</span>
								</b-col>

								<b-col lg="3" md="4" sm="6">
									<span>{{ $t('ROOM_MANAGEMENT.LEVEL') }}</span>
									<span>{{ task.level }}</span>
								</b-col>

								<b-col lg="3" md="4" sm="6">
									<span>{{ $t('ROOM_MANAGEMENT.ROOM_NUMBER') }}</span>
									<span>{{ task.room }}</span>
								</b-col>

								<b-col v-if="listAddedTask.length > 0" cols="12">
									<b-row>
										<b-col cols="6">
											<v-text-field
												v-model="task.spent_time_hour"
												outlined
												onkeydown="javascript: return event.keyCode === 8 || event.keyCode === 46 ? true : !isNaN(Number(event.key))"
												:label="$t('SCHEDULE_MANAGEMENT.SPENT_TIME')"
												:suffix="task.spent_time_hour <= 1 ? $t('SCHEDULE_MANAGEMENT.HOUR') : $t('SCHEDULE_MANAGEMENT.HOURS')"
												:rules="[rules.workingHour]"
												:disabled="!isDisabled"
											/>
										</b-col>

										<b-col cols="6">
											<v-text-field
												v-model="task.spent_time_minute"
												outlined
												onkeydown="javascript: return event.keyCode === 8 || event.keyCode === 46 ? true : !isNaN(Number(event.key))"
												:label="$t('SCHEDULE_MANAGEMENT.SPENT_TIME')"
												:suffix="task.spent_time_minute <= 1 ? $t('SCHEDULE_MANAGEMENT.MINUTE') : $t('SCHEDULE_MANAGEMENT.MINUTES')"
												:rules="[rules.workingMinute]"
												:disabled="!isDisabled"
											/>
										</b-col>

										<b-col cols="6">
											<v-select
												v-model="task.task_status"
												:items="taskStatus"
												:label="$t('SCHEDULE_MANAGEMENT.TASK_STATUS.TITLE')"
												outlined
												:item-disabled="item => role === 'staff' ? (item.value === 4 || item.value === 5) : ''"
												@input="getTaskInfo()"
											/>
										</b-col>

										<b-col cols="6">
											<v-select
												v-model="schedule.log_time.approve"
												:items="approveStatus"
												:label="$t('SCHEDULE_MANAGEMENT.APPROVE_STATUS.TITLE')"
												outlined
												:disabled="isDisabled"
												@input="getTaskInfo()"
											/>
										</b-col>

										<b-col cols="12">
											<v-textarea
												v-model="task.remark"
												outlined
												:label="$t('SCHEDULE_MANAGEMENT.REMARK')"
											/>
										</b-col>

										<b-col cols="12" class="text-left">
											<v-btn text class="text-primary text-underline" @click="updateTask(task.id, task.spent_time_hour, task.spent_time_minute, task.task_status, task.remark)">
												<i class="fas fa-feather-alt" />
												<span>{{ $t('BUTTON.SAVE') }}</span>
											</v-btn>
										</b-col>
									</b-row>
								</b-col>
							</b-row>

						</v-card-text>

						<v-card-actions>
							<v-row>
								<v-col cols="12" class="text-left">
									<v-btn class="danger-btn" @click="detailScheduleDialog = false">
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
import { getAllBuilding } from '@/api/modules/building';

import { getAllDepartment } from '@/api/modules/department';

import { getAllTask } from '@/api/modules/task';

import { getAllPosition } from '@/api/modules/position';

import { getAllContract } from '@/api/modules/contract';

import { getAllSchedule, getOneSchedule, updateSchedule } from '@/api/modules/schedule';

import { updateTimesheet } from '@/api/modules/timesheet';

import { convertFromIDToName } from '@/utils/convertFromIdToName';

import { MakeToast } from '@/utils/MakeToast';

import { validateAddNewTask } from './validationAddNewTask';

import { cleanObj } from '@/utils/handleObj';

import { obj2Path } from '@/utils/obj2Path';

import vHeaderFilter from '@/components/atoms/vHeaderFilter';

import vSelectGroup from '@/components/atoms/vSelectGroup';

const urlAPI = {
    apiGetAllBuilding: '/building/list',
    apiGetAllPosition: '/position/list',
    apiGetAllContract: '/contract/list',
    apiGetAllDepartment: '/department/list',
    apiGetAllTask: '/task/all',
    apiGetAllSchedule: '/schedule-management/list',
    apiGetOneSchedule: '/schedule-management/detail',
    apiUpdateSchedule: '/schedule-management/update',
    apiUpdateTimesheetSchedule: '/timesheet-management/update',
};

export default {
    name: 'ScheduleManagementList',
    components: {
        vHeaderFilter,
        vSelectGroup,
    },
    data() {
        return {
            roles: [
                { value: null, text: this.$t('PLACE_HOLDER.PLEASE_SELECT') },
                { value: 1, text: this.$t('ROLE.ADMIN') },
                { value: 2, text: this.$t('ROLE.MANAGER') },
                { value: 3, text: this.$t('ROLE.STAFF') },
            ],

            tasks: [
                { value: null, text: this.$t('PLACE_HOLDER.PLEASE_SELECT') },
            ],

            contract_type: [
                { value: null, text: this.$t('PLACE_HOLDER.PLEASE_SELECT') },
            ],

            positions: [
                { value: null, text: this.$t('PLACE_HOLDER.PLEASE_SELECT') },
            ],

            buildings: [
                { value: null, text: this.$t('PLACE_HOLDER.PLEASE_SELECT') },
            ],

            ListBuilding: [],

            rooms: [
                { value: null, text: this.$t('PLACE_HOLDER.PLEASE_SELECT') },
            ],

            departments: [
                { value: null, text: this.$t('PLACE_HOLDER.PLEASE_SELECT') },
            ],

            levels: [
                { value: null, text: this.$t('PLACE_HOLDER.PLEASE_SELECT') },
            ],

            taskStatus: [
                { value: 1, text: this.$t('SCHEDULE_MANAGEMENT.TASK_STATUS.PENDING') },
                { value: 2, text: this.$t('SCHEDULE_MANAGEMENT.TASK_STATUS.IN_PROGRESS') },
                { value: 3, text: this.$t('SCHEDULE_MANAGEMENT.TASK_STATUS.COMPLETED') },
                { value: 4, text: this.$t('SCHEDULE_MANAGEMENT.TASK_STATUS.FEEDBACK') },
                { value: 5, text: this.$t('SCHEDULE_MANAGEMENT.TASK_STATUS.ABORTED') },
            ],

            approveStatus: [
                { value: 1, text: this.$t('SCHEDULE_MANAGEMENT.TASK_STATUS.PENDING') },
                { value: 2, text: this.$t('SCHEDULE_MANAGEMENT.APPROVE_STATUS.APPROVED') },
                { value: 3, text: this.$t('SCHEDULE_MANAGEMENT.APPROVE_STATUS.REFUSED') },
            ],

            ScheduleList: [],

            filter: {
                department: {
                    status: false,
                    value: null,
                },
                position: {
                    status: false,
                    value: null,
                },
                contract_type: {
                    status: false,
                    value: null,
                },
            },

            schedule: {
                user: {
                    user_id: '',
                    user_code: '',
                    user_name: '',
                    role: '',
                    position: '',
                    department: '',
                    contract_type: '',
                },

                work_place: {
                    building: '',
                    level: '',
                    room: '',
                },

                task: {
                    task_name: null,
                    task_description: '',
                },

                time: {
                    date: '',
                    start_time: '',
                    end_time: '',
                },

                log_time: {
                    status: 1,
                    spent_time: {
                        hour: '00',
                        minute: '00',
                    },
                    remark: '',
                    approve: 1,
                },
            },

            filterQuery: {
                order_column: '',
                order_type: '',
            },

            convertFromIDToName: convertFromIDToName,

            search: '',

            assignNewTaskDialog: false,

            detailScheduleDialog: false,

            isShowScheduleDetailDialog: false,

            isShowAssignNewTaskDialog: false,

            dialogSelectStartTime: false,

            dialogSelectEndTime: false,

            dialogSelectDate: false,

            listAddedTask: [],

            headers: [
                { text: this.$t('SCHEDULE_MANAGEMENT.USER_NAME'), sortable: false, value: 'user_name' },
                { text: this.$t('SCHEDULE_MANAGEMENT.POSITION'), sortable: false, value: 'position_id' },
                { text: this.$t('SCHEDULE_MANAGEMENT.CONTRACT_TYPE'), sortable: false, value: 'contract_type' },
                { text: this.$t('SCHEDULE_MANAGEMENT.DEPARTMENT'), sortable: false, value: 'department_id' },
                { text: this.$t('SCHEDULE_MANAGEMENT.ASSIGN_STATUS.TITLE'), sortable: true, value: 'schedules' },
                { text: this.$t('BUTTON.SCHEDULE_DETAIL'), sortable: false, value: 'schedule_detail_action' },
                { text: this.$t('BUTTON.ASSIGN_TASK'), sortable: false, value: 'assign_new_task_action' },
            ],

            overlay: {
                show: false,
                variant: 'light',
                opacity: 1,
                blur: '1rem',
                rounded: 'sm',
            },

            language: this.$store.getters.language,

            rules: {
                workingHour: value => (value >= 0 && value <= 23) || this.$t('SCHEDULE_MANAGEMENT.INVALID_TIME'),
                workingMinute: value => (value >= 0 && value <= 59) || this.$t('SCHEDULE_MANAGEMENT.INVALID_TIME'),
            },

            temporary_id: '',
        };
    },

    computed: {
        role() {
            return this.$store.getters.roles[0];
        },

        isDisabled() {
            return !((this.role === 'admin' || this.role === 'manager'));
        },
    },

    created() {
        this.getScheduleManagementData();
    },

    methods: {
        async getScheduleManagementData() {
            await this.getListSchedule();

            this.overlay.show = true;

            await this.getListBuilding();
            await this.getListDepartment();
            await this.getListDepartment();
            await this.getListTask();
            await this.getPositionList();
            await this.getContractType();

            this.overlay.show = false;
        },

        async getListSchedule() {
            this.overlay.show = true;

            try {
                let QUERY = {
                    department: this.filter.department.value,
                    position: this.filter.position.value,
                    contract: this.filter.contract_type.value,
                    user_id: '',
                    sortby: this.filterQuery['order_column'],
                    sorttype: this.filterQuery['order_type'],
                };

                if (this.role === 'admin' || this.role === 'manager') {
                    QUERY.user_id = '';
                } else {
                    QUERY.user_id = parseInt(this.$store.getters.userId - 3);
                }

                QUERY = cleanObj(QUERY);

                const URL = `${urlAPI.apiGetAllSchedule}?${obj2Path(QUERY)}`;

                const response = await getAllSchedule(URL);

                if (response.code === 200) {
                    this.ScheduleList = response.data;
                }
            } catch (error) {
                console.log(error);
            }

            this.overlay.show = false;
        },

        async getListBuilding() {
            try {
                const response = await getAllBuilding(urlAPI.apiGetAllBuilding);

                if (response.code === 200) {
                    this.ListBuilding = response.data;

                    for (let i = 0; i < response.data.length; i++) {
                        this.buildings.push({
                            text: response.data[i].building_name,
                            value: response.data[i].id,
                        });
                    }
                }
            } catch (error) {
                console.log(error);
            }
        },

        setLevelByRoomNumber() {
            const room_id = this.schedule.work_place.room;

            for (let i = 0; i < this.ListBuilding.length; i++) {
                for (let j = 0; j < this.ListBuilding[i].rooms.length; j++) {
                    if (this.ListBuilding[i].rooms[j].id === room_id) {
                        this.schedule.work_place.level = this.ListBuilding[i].rooms[j].level;
                    }
                }
            }
        },

        addNewTaskInAssignedList() {
            const DATA = {
                id: this.listAddedTask.length + 1,
                task_name: this.schedule.task.task_name,
                date: this.schedule.time.date,
                start_time: this.schedule.time.start_time,
                end_time: this.schedule.time.end_time,
                building: this.schedule.work_place.building,
                level: this.schedule.work_place.level,
                room: this.schedule.work_place.room,
                spent_time_hour: this.schedule.log_time.spent_time.hour,
                spent_time_minute: this.schedule.log_time.spent_time.minute,
                task_status: this.schedule.log_time.status,
                approve_status: this.schedule.log_time.approve,
                spent_time: `${this.schedule.log_time.spent_time.hour}:${this.schedule.log_time.spent_time.minute}`,
                remark: this.schedule.log_time.remark,
            };

            if (validateAddNewTask(DATA) === true) {
                this.listAddedTask.push(DATA);

                MakeToast({
                    variant: 'success',
                    title: this.$t('TOAST.TITLE.SUCCESS'),
                    content: this.$t('TOAST.CONTENT.SCHEDULE_MANAGEMENT.ADD_NEW_TASK_SUCCESS'),
                });

                this.schedule.task.task_name = null;
                this.schedule.time.date = '';
                this.schedule.time.start_time = '';
                this.schedule.time.end_time = '';
                this.schedule.work_place.building = null;
                this.schedule.work_place.level = null;
                this.schedule.work_place.room = null;
                this.schedule.log_time.status = 1;
                this.schedule.log_time.approve = 1;
                this.schedule.log_time.spent_time.hour = '00';
                this.schedule.log_time.spent_time.minute = '00';
                this.schedule.log_time.remark = '';
            }
        },

        async updateTask(id, spent_time_hour, spent_time_minute, task_status, remark) {
            for (let i = 0; i < this.listAddedTask.length; i++) {
                if (this.listAddedTask[i].id === id) {
                    this.listAddedTask[i].spent_time = `${spent_time_hour}:${spent_time_minute}`;
                    this.listAddedTask[i].task_status = task_status;
                    this.listAddedTask[i].remark = remark;
                }
            }

            await this.doUpdateSchedule();

            await this.getDetailScheduleInformation(this.temporary_id);
        },

        removeTaskFromAssignedList(index) {
            console.log(index);
            this.listAddedTask.splice(index, 1);
        },

        getListRoomByBuilding() {
            this.schedule.work_place.level = '';

            const building_id = this.schedule.work_place.building;

            for (let i = 0; i < this.ListBuilding.length; i++) {
                if (this.ListBuilding[i].id === building_id) {
                    this.rooms = [];

                    this.rooms.push({
                        text: this.$t('PLACE_HOLDER.PLEASE_SELECT'),
                        value: null,
                    });

                    for (let j = 0; j < this.ListBuilding[i].rooms.length; j++) {
                        this.rooms.push({
                            text: this.ListBuilding[i].rooms[j].room_number,
                            value: this.ListBuilding[i].rooms[j].id,
                        });
                    }
                }
            }
        },

        async getListDepartment() {
            try {
                const response = await getAllDepartment(urlAPI.apiGetAllDepartment);

                if (response.code === 200) {
                    for (let i = 0; i < response.data.length; i++) {
                        this.departments.push({
                            text: response.data[i].department_name,
                            value: response.data[i].id,
                        });
                    }
                }
            } catch (error) {
                console.log(error);
            }
        },

        async getListTask() {
            try {
                const response = await getAllTask(urlAPI.apiGetAllTask);

                if (response.code === 200) {
                    for (let i = 0; i < response.data.length; i++) {
                        this.tasks.push({
                            text: response.data[i].task_name,
                            value: response.data[i].id,
                            description: response.data[i].task_description,
                        });
                    }
                }
            } catch (error) {
                console.log(error);
            }
        },

        getTaskInfo() {
            const task_id = this.schedule.task.task_name;
            for (let i = 0; i < this.tasks.length; i++) {
                if (this.tasks[i].value === task_id) {
                    this.schedule.task.task_description = this.tasks[i].description;
                }
            }
        },

        async getContractType() {
            try {
                const response = await getAllContract(urlAPI.apiGetAllContract);

                if (response.code === 200) {
                    for (let i = 0; i < response.data.length; i++) {
                        this.contract_type.push({
                            text: this.$t(`CONTRACT.${response.data[i].contract_type}`),
                            value: response.data[i].id,
                        });
                    }
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
                        this.positions.push({
                            text: this.$t(`POSITION.${response.data[i].position_name}`),
                            value: response.data[i].id,
                        });
                    }
                }
            } catch (error) {
                console.log(error);
            }
        },

        openScheduleDetailDialog(id) {
            this.detailScheduleDialog = true;

            this.temporary_id = id;

            this.getDetailScheduleInformation(id);
        },

        async openAssignNewTaskDialog(id) {
            this.schedule.task.task_name = null;
            this.schedule.time.date = '';
            this.schedule.time.start_time = '';
            this.schedule.time.end_time = '';
            this.schedule.work_place.building = null;
            this.schedule.work_place.level = null;
            this.schedule.work_place.room = null;

            await this.getDetailScheduleInformation(id);

            this.assignNewTaskDialog = true;
        },

        async getDetailScheduleInformation(id) {
            try {
                const URL = `${urlAPI.apiGetOneSchedule}/${id}`;
                const response = await getOneSchedule(URL);

                if (response.code === 200) {
                    this.listAddedTask = response.data.schedules;
                    this.schedule.user.user_id = response.data.id;
                    this.schedule.user.user_code = response.data.user_code;
                    console.log(this.schedule.user.user_code);
                    this.schedule.user.user_name = response.data.user_name;
                    this.schedule.user.role = response.data.role_id;
                    this.schedule.user.position = response.data.position_id;
                    this.schedule.user.department = response.data.department_id;
                    this.schedule.user.contract_type = response.data.contract_type;
                }
            } catch (error) {
                console.log(error);
            }
        },

        async doUpdateSchedule() {
            const DATA_SCHEDULE = {
                schedules: this.listAddedTask,
            };

            const DATA_TIMESHEET = {
                schedule: this.listAddedTask,
            };

            try {
                const URL = `${urlAPI.apiUpdateSchedule}/${this.schedule.user.user_id}`;

                const response = await updateSchedule(URL, DATA_SCHEDULE);

                const URL_TIMESHEET = `${urlAPI.apiUpdateTimesheetSchedule}/${this.schedule.user.user_code}`;

                await updateTimesheet(URL_TIMESHEET, DATA_TIMESHEET);

                if (response.code === 200) {
                    MakeToast({
                        variant: 'success',
                        title: this.$t('TOAST.TITLE.SUCCESS'),
                        content: this.$t('TOAST.CONTENT.SCHEDULE_MANAGEMENT.UPDATE_SCHEDULE_SUCCESS'),
                    });

                    await this.getListSchedule();

                    this.assignNewTaskDialog = false;
                } else {
                    MakeToast({
                        variant: 'warning',
                        title: this.$t('TOAST.TITLE.WARNING'),
                        content: this.$t('TOAST.CONTENT.SCHEDULE_MANAGEMENT.UPDATE_SCHEDULE_FAILED'),
                    });

                    this.assignNewTaskDialog = false;
                }
            } catch (error) {
                console.log(error);

                this.assignNewTaskDialog = false;
            }

            this.listAddedTask = [];
        },

        doApplyFilter() {
            this.getListSchedule();
        },

        doClearFilter() {
            this.filter = {
                department: {
                    status: false,
                    value: null,
                },
                position: {
                    status: false,
                    value: null,
                },
                contract_type: {
                    status: false,
                    value: null,
                },
            };
        },

        getIsCheckFilterDepartment(value) {
            this.filter.department.status = value;
        },

        getIsCheckFilterPosition(value) {
            this.filter.position.status = value;
        },

        getIsCheckFilterContractType(value) {
            this.filter.contract_type.status = value;
        },
    },
};
</script>

<style lang="scss" scoped>
  @import "@/scss/variables.scss";

  .schedule-management {

    ::v-deep .v-dialog {
      overflow-y: visible;
    }

    .schedule-management-list-table {
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

  .fa-minus-square:hover {
      cursor: pointer;
  }

  ::v-deep .v-data-table-header__icon {
      color: $white !important;
  }

  @media (max-width: 768px) {
    .schedule-management {
      max-height: 100%;
    }
  }
</style>
