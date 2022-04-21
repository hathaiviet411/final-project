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

				<span>Schedule Management</span>

				<v-row class="my-3 mx-3">
					<v-col cols="12">
						<v-card elevation="24">
							<v-card-title>
								<b-row>
									<b-col lg="6" md="12" sm="12">
										<v-text-field
											v-model="search"
											append-icon="mdi-magnify"
											:label="$t('BUTTON.SEARCH')"
											single-line
											hide-details
										/>
									</b-col>

									<b-col lg="6" md="12" sm="12" class="text-center">
										<v-select
											v-model="department"
											class="mx-auto"
											style="max-width: 200px !important;"
											:items="DepartmentList"
											:label="$t('SCHEDULE_MANAGEMENT.DEPARTMENT')"
											outlined
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
								</v-data-table>
							</v-card-text>
						</v-card>
					</v-col>
				</v-row>

			</b-overlay>
		</v-app>
	</div>
</template>

<script>
import { getAllDepartment } from '@/api/modules/department';

import { MakeToast } from '@/utils/MakeToast';

const urlAPI = {
    apiGetAllDepartment: '/department/list',
};

export default {
    name: 'ScheduleManagementList',
    data() {
        return {
            DepartmentList: [],

            ScheduleList: [
                {
                    id: 1,
                    user_name: 'Nguyễn Bảo Linh',
                    position: 'Receptionist',
                    contract_type: 'Full Time',
                },
                {
                    id: 2,
                    user_name: 'Trần Hồng Linh',
                    position: 'Housekeeping',
                    contract_type: 'Part Time',
                },
                {
                    id: 3,
                    user_name: 'Bùi Thuý Hằng',
                    position: 'Public Area Cleaner',
                    contract_type: 'Full Time',
                },
                {
                    id: 4,
                    user_name: 'Nguyễn Than Hoàn',
                    position: 'Laundry',
                    contract_type: 'Part Time',
                },
            ],

            department: 1,

            search: '',

            isShowScheduleDetailDialog: false,
            isShowAssignNewTaskDialog: false,

            headers: [
                { text: this.$t('SCHEDULE_MANAGEMENT.USER_NAME'), sortable: false, value: 'user_name' },
                { text: this.$t('SCHEDULE_MANAGEMENT.POSITION'), sortable: false, value: 'position' },
                { text: this.$t('SCHEDULE_MANAGEMENT.CONTRACT_TYPE'), sortable: false, value: 'contract_type' },
                { text: this.$t('BUTTON.SCHEDULE_DETAIL'), sortable: false, value: 'schedule_detail_action' },
                { text: this.$t('BUTTON.ASSIGN_NEW_TASK'), sortable: false, value: 'assign_new_task_action' },
            ],

            items: [],

            overlay: {
                show: false,
                variant: 'light',
                opacity: 1,
                blur: '1rem',
                rounded: 'sm',
            },
        };
    },

    created() {
        this.getListDepartment();
    },

    methods: {
        async getListDepartment() {
            try {
                const response = await getAllDepartment(urlAPI.apiGetAllDepartment);

                console.log(response);

                if (response.code === 200) {
                    for (let i = 0; i < response.data.length; i++) {
                        this.DepartmentList.push({
                            text: response.data[i].department_name,
                            value: response.data[i].id,
                        });
                    }
                }
            } catch (error) {
                MakeToast({
                    variant: 'warning',
                    title: this.$t('TOAST.TITLE.WARNING'),
                    content: error || this.$t('TOAST.TITLE.ERROR'),
                });
            }
        },

        openScheduleDetailDialog(id) {
            console.log(id);
        },

        openAssignNewTaskDialog(id) {
            console.log(id);
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
