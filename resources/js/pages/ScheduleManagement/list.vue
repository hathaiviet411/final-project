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
									<b-col cols="12">
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
										<v-btn fab dark small color="#3F0071">
											<v-icon small @click="openScheduleDetailDialog(item.id)">fas fa-calendar-day</v-icon>
										</v-btn>
									</template>

									<template #[`item.assign_new_task_action`]="{ item }">
										<v-btn fab dark small color="#1E2AA5">
											<v-icon small @click="openAssignNewTaskDialog(item.id)">fas fa-layer-plus</v-icon>
										</v-btn>
									</template>

									<template #[`item.department_id`]="{ item }">
										<span>{{ convertFromIDToName(item.department_id, departments) }}</span>
									</template>

									<template #[`item.position_id`]="{ item }">
										<span>{{ convertFromIDToName(item.position_id, positions) }}</span>
									</template>

									<template #[`item.contract_id`]="{ item }">
										<span>{{ convertFromIDToName(item.contract_id, contract_type) }}</span>
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

							<b-row>
								<b-col lg="6" md="12" sm="12">
									<v-select
										v-model="schedule.work_place.building"
										:label="$t('SCHEDULE_MANAGEMENT.BUILDING')"
										:items="buildings"
										outlined
										@input="getListRoomByBuilding()"
									/>
								</b-col>

								<b-col lg="6" md="12" sm="12">
									<v-text-field
										v-model="schedule.work_place.level"
										:label="$t('SCHEDULE_MANAGEMENT.LEVEL')"
										outlined
										disabled
									/>
								</b-col>
							</b-row>

							<b-row>
								<b-col cols="12">
									<v-select
										v-model="schedule.work_place.room"
										:label="$t('SCHEDULE_MANAGEMENT.ROOM')"
										:items="rooms"
										outlined
										@input="setLevelByRoomNumber()"
									/>
								</b-col>
							</b-row>

							<span class="text-bold h6">{{ $t('SCHEDULE_MANAGEMENT.WORKING_TIME_INFORMATION') }}</span>

							<v-divider />

							<b-row>
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

							<span class="text-bold h6">{{ $t('SCHEDULE_MANAGEMENT.TASK_INFORMATION') }}</span>

							<v-divider />

							<b-row>
								<b-col lg="12" md="12" sm="12">
									<v-select
										v-model="schedule.task.task_name"
										:items="tasks"
										:label="$t('TASK_MANAGEMENT.TASK_NAME')"
										outlined
										@input="getTaskInfo()"
									/>
								</b-col>
							</b-row>

							<b-row>
								<b-col lg="12" md="12" sm="12">
									<v-textarea
										:value="schedule.task.task_description"
										:placeholder="$t('TASK_MANAGEMENT.TASK_DESCRIPTION')"
										outlined
										readonly
									/>
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
									<v-btn class="primary-btn" @click="doRegisterSchedule()">
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
										v-model="schedule.user.contract"
										:label="$t('SCHEDULE_MANAGEMENT.CONTRACT_TYPE')"
										:items="roles"
										outlined
										disabled
									/>
								</b-col>
							</b-row>

							<span class="text-bold h6">{{ $t('SCHEDULE_MANAGEMENT.WORKING_PLACE_INFORMATION') }}</span>

							<v-divider />

							<b-row>
								<b-col lg="6" md="12" sm="12">
									<v-select
										v-model="schedule.work_place.building"
										:label="$t('SCHEDULE_MANAGEMENT.BUILDING')"
										:items="buildings"
										outlined
										disabled
									/>
								</b-col>

								<b-col lg="6" md="12" sm="12">
									<v-select
										v-model="schedule.work_place.level"
										:label="$t('SCHEDULE_MANAGEMENT.LEVEL')"
										:items="levels"
										outlined
										disabled
									/>
								</b-col>
							</b-row>

							<b-row>
								<b-col cols="12">
									<v-select
										v-model="schedule.work_place.room"
										:label="$t('SCHEDULE_MANAGEMENT.ROOM')"
										:items="rooms"
										outlined
										disabled
									/>
								</b-col>
							</b-row>

							<span class="text-bold h6">{{ $t('SCHEDULE_MANAGEMENT.WORKING_TIME_INFORMATION') }}</span>

							<v-divider />

							<b-row>
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

							<span class="text-bold h6">{{ $t('SCHEDULE_MANAGEMENT.TASK_INFORMATION') }}</span>

							<v-divider />

							<b-row>
								<b-col lg="6" md="12" sm="12">
									<v-select
										v-model="schedule.task.task_name"
										:items="tasks"
										:label="$t('TASK_MANAGEMENT.TASK_NAME')"
										outlined
									/>
								</b-col>

								<b-col lg="6" md="12" sm="12">
									<v-text-field
										v-model="schedule.task.task_description"
										:label="$t('TASK_MANAGEMENT.TASK_DESCRIPTION')"
										outlined
									/>
								</b-col>
							</b-row>

							<span class="text-bold h6">{{ $t('SCHEDULE_MANAGEMENT.LOG_TIME') }}</span>

							<v-divider />

							<b-row>
								<b-col lg="6" md="12" sm="12">
									<v-select
										v-model="schedule.log_time.status"
										:label="$t('SCHEDULE_MANAGEMENT.TASK_STATUS.TITLE')"
										:items="taskStatus"
										outlined
									/>
								</b-col>

								<b-col lg="6" md="12" sm="12">
									<v-text-field
										v-model="schedule.log_time.spent_time"
										:label="$t('SCHEDULE_MANAGEMENT.SPENT_TIME')"
										outlined
									/>
								</b-col>
							</b-row>

							<b-row>
								<b-col lg="6" md="12" sm="12">
									<v-text-field
										v-model="schedule.log_time.remark"
										:label="$t('SCHEDULE_MANAGEMENT.REMARK')"
										outlined
									/>
								</b-col>

								<b-col v-if="role !== 'staff'" lg="6" md="12" sm="12">
									<v-select
										v-model="schedule.log_time.approve"
										:label="$t('SCHEDULE_MANAGEMENT.APPROVE_STATUS.TITLE')"
										:items="approveStatus"
										outlined
									/>
								</b-col>
							</b-row>

						</v-card-text>

						<v-card-actions>
							<v-row>
								<v-col cols="6" class="text-center">
									<v-btn class="danger-btn" @click="detailScheduleDialog = false">
										<v-icon left>mdi-close-box</v-icon>
										<span>{{ $t('BUTTON.CANCEL') }}</span>
									</v-btn>
								</v-col>

								<v-col cols="6" class="text-center">
									<v-btn class="primary-btn" @click="doRegisterSchedule()">
										<v-icon left>fas fa-plus-circle</v-icon>
										<span>{{ $t('BUTTON.SAVE') }}</span>
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

import { getAllUser } from '@/api/modules/user';

import { getAllDepartment } from '@/api/modules/department';

import { getAllTask } from '@/api/modules/task';

import { getAllPosition } from '@/api/modules/position';

import { getAllContract } from '@/api/modules/contract';

import { convertFromIDToName } from '@/utils/convertFromIdToName';
import vTextarea from '../../components/atoms/vTextarea.vue';

// import { MakeToast } from '@/utils/MakeToast';

const urlAPI = {
    apiGetAllBuilding: '/building/list',
    apiGetAllPosition: '/position/list',
    apiGetAllContract: '/contract/list',
    apiGetAllUser: '/users/all',
    apiGetOneUser: '/users/detail/',
    apiGetAllDepartment: '/department/list',
    apiGetAllTask: '/task/all',
};

export default {
    name: 'ScheduleManagementList',
    components: { vTextarea },
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
                { value: null, text: this.$t('PLACE_HOLDER.PLEASE_SELECT') },
                { value: 1, text: this.$t('SCHEDULE_MANAGEMENT.TASK_STATUS.IN_PROGRESS') },
                { value: 2, text: this.$t('SCHEDULE_MANAGEMENT.TASK_STATUS.COMPLETED') },
                { value: 3, text: this.$t('SCHEDULE_MANAGEMENT.TASK_STATUS.FEEDBACK') },
            ],

            approveStatus: [
                { value: null, text: this.$t('PLACE_HOLDER.PLEASE_SELECT') },
                { value: 1, text: this.$t('SCHEDULE_MANAGEMENT.APPROVE_STATUS.APPROVED') },
                { value: 2, text: this.$t('SCHEDULE_MANAGEMENT.APPROVE_STATUS.REFUSED') },
            ],

            ScheduleList: [],

            schedule: {
                user: {
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
                    start_time: '',
                    end_time: '',
                },

                log_time: {
                    status: null,
                    spent_time: '',
                    remark: '',
                    approve: null,
                },
            },

            convertFromIDToName: convertFromIDToName,

            search: '',

            assignNewTaskDialog: false,

            detailScheduleDialog: false,

            isShowScheduleDetailDialog: false,

            isShowAssignNewTaskDialog: false,

            dialogSelectStartTime: false,

            dialogSelectEndTime: false,

            headers: [
                { text: this.$t('SCHEDULE_MANAGEMENT.USER_NAME'), sortable: false, value: 'user_name' },
                { text: this.$t('SCHEDULE_MANAGEMENT.POSITION'), sortable: false, value: 'position_id' },
                { text: this.$t('SCHEDULE_MANAGEMENT.CONTRACT_TYPE'), sortable: false, value: 'contract_id' },
                { text: this.$t('SCHEDULE_MANAGEMENT.DEPARTMENT'), sortable: false, value: 'department_id' },
                { text: this.$t('BUTTON.SCHEDULE_DETAIL'), sortable: false, value: 'schedule_detail_action' },
                { text: this.$t('BUTTON.ASSIGN_NEW_TASK'), sortable: false, value: 'assign_new_task_action' },
            ],

            overlay: {
                show: false,
                variant: 'light',
                opacity: 1,
                blur: '1rem',
                rounded: 'sm',
            },
        };
    },

    computed: {
        role() {
            return this.$store.getters.roles[0];
        },
    },

    created() {
        this.getScheduleManagementData();
    },

    methods: {
        async getScheduleManagementData() {
            await this.getListBuilding();
            await this.getListUser();
            await this.getListDepartment();
            await this.getListDepartment();
            await this.getListTask();
            await this.getPositionList();
            await this.getContractType();
        },

        async getListBuilding() {
            this.overlay.show = true;

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

        async getListUser() {
            try {
                const response = await getAllUser(urlAPI.apiGetAllUser);

                if (response.code === 200) {
                    this.ScheduleList = response.data;
                }
            } catch (error) {
                console.log(error);
            }
        },

        async getDetailUserInformation(user_id) {
            try {
                const response = await getAllUser(`${urlAPI.apiGetOneUser}${user_id}`);

                if (response.code === 200) {
                    this.schedule.user.user_name = response.data.user_name;
                    this.schedule.user.role = response.data.roles[0].id;
                    this.schedule.user.position = response.data.position_id;
                    this.schedule.user.department = response.data.department_id;
                    this.schedule.user.contract_type = response.data.contract_id;
                }
            } catch (error) {
                console.log(error);
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
                    console.log(this.schedule.task.task_description);
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

            this.overlay.show = false;
        },

        openScheduleDetailDialog(id) {
            this.detailScheduleDialog = true;
            console.log(id);
        },

        async openAssignNewTaskDialog(id) {
            console.log(id);
            await this.getDetailUserInformation(id);
            this.assignNewTaskDialog = true;
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

  @media (max-width: 768px) {
    .schedule-management {
      max-height: 100%;
    }
  }
</style>
