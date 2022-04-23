<template>
	<div class="task-management">
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
											<span>{{ $t('TASK_MANAGEMENT.NEW_TASK') }}</span>
										</v-btn>
									</b-col>
								</b-row>
							</v-card-title>

							<v-data-table
								class="task-management-list-table mt-3"
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
									<v-row>
										<v-col cols="6" class="text-right">
											<v-icon small class="text-primary" @click="getSpecificTask(item.id)">fas fa-edit</v-icon>
										</v-col>

										<v-col cols="6" class="text-left">
											<v-icon small class="text-danger" @click="deleteDialog = true, deleting_id = item.id">fas fa-trash-alt</v-icon>
										</v-col>
									</v-row>
								</template>

								<template #[`item.required_position`]="{ item }">
									<span>{{ convertFromIDToName(item.required_position, PositionList) }}</span>
								</template>

								<template #[`item.required_contract_type`]="{ item }">
									<span>{{ convertFromIDToName(item.required_contract_type, ContractType) }}</span>
								</template>
							</v-data-table>
						</v-card>
					</v-col>
				</v-row>

				<!-- Register Dialog -->
				<v-dialog v-model="registerDialog" max-width="500" persistent>
					<v-card>
						<v-btn elevation="3" block tile class="mb-3 cornflower">
							<span>{{ $t('TASK_MANAGEMENT.NEW_TASK') }}</span>
						</v-btn>

						<v-card-text>
							<v-row class="mt-1">
								<v-col cols="12">
									<v-text-field
										v-model="task.task_name"
										:label="$t('TASK_MANAGEMENT.TASK_NAME')"
										outlined
									/>
								</v-col>

								<v-col cols="12">
									<v-textarea
										v-model="task.task_description"
										outlined
										no-resize
										:label="$t('TASK_MANAGEMENT.TASK_DESCRIPTION')"
									/>
								</v-col>

								<v-col cols="12">
									<v-select v-model="task.required_position" :items="PositionList" outlined :label="$t('TASK_MANAGEMENT.REQUIRED_POSITION')">
										<template #prepend-item>
											<v-list-item>
												<v-list-item-content>
													<v-text-field v-model="search_position" :placeholder="$t('BUTTON.SEARCH')" @input="searchPositions" />
												</v-list-item-content>
											</v-list-item>
											<v-divider class="mt-2" />
										</template>
									</v-select>
								</v-col>

								<v-col cols="12">
									<v-select
										v-model="task.required_contract_type"
										:items="ContractType"
										:label="$t('TASK_MANAGEMENT.REQUIRED_CONTRACT_TYPE')"
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
									<v-btn class="primary-btn" @click="doRegisterTask()">
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
						<v-btn elevation="3" block tile class="mb-3 cornflower" @click="editDialog = true">
							<span>{{ $t('TASK_MANAGEMENT.EDIT_TASK') }}</span>
						</v-btn>

						<v-card-text>
							<v-row class="mt-1">
								<v-col cols="12">
									<v-text-field
										v-model="task.task_name"
										:label="$t('TASK_MANAGEMENT.TASK_NAME')"
										outlined
									/>
								</v-col>

								<v-col cols="12">
									<v-textarea
										v-model="task.task_description"
										outlined
										no-resize
										:label="$t('TASK_MANAGEMENT.TASK_DESCRIPTION')"
									/>
								</v-col>

								<v-col cols="12">
									<v-select v-model="task.required_position" :items="PositionList" outlined :label="$t('TASK_MANAGEMENT.REQUIRED_POSITION')">
										<template #prepend-item>
											<v-list-item>
												<v-list-item-content>
													<v-text-field v-model="search_position" :placeholder="$t('BUTTON.SEARCH')" @input="searchPositions" />
												</v-list-item-content>
											</v-list-item>
											<v-divider class="mt-2" />
										</template>
									</v-select>
								</v-col>

								<v-col cols="12">
									<v-select
										v-model="task.required_contract_type"
										:items="ContractType"
										:label="$t('TASK_MANAGEMENT.REQUIRED_CONTRACT_TYPE')"
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
									<v-btn class="primary-btn" @click="doUpdateTask(task.id)">
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
							<span>{{ $t('TASK_MANAGEMENT.DELETE_TASK') }}</span>
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
									<v-btn class="danger-btn" @click="doRemoveTask(deleting_id)">
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
    getAllTask,
    getOneTask,
    createTask,
    updateTask,
    deleteTask,
}
from '@/api/modules/task';

import { getAllPosition } from '@/api/modules/position';

import { getAllContract } from '@/api/modules/contract';

import { MakeToast } from '@/utils/MakeToast';

import { convertFromIDToName } from '@/utils/convertFromIdToName';

const urlAPI = {
    apiGetAllTask: '/task/list',
    apiGetAllPosition: '/position/list',
    apiGetAllContract: '/contract/list',
    apiGetOneTask: '/task/detail/',
    apiCreateTask: '/task/create',
    apiUpdateTask: '/task/update/',
    apiDeleteTask: '/task/delete/',
};

export default {
    name: 'TaskManagementIndex',
    data() {
        return {
            PositionList: [
                { value: null, text: this.$t('PLACE_HOLDER.PLEASE_SELECT') },
            ],

            PositionListCopy: [],

            ContractType: [
                { value: null, text: this.$t('PLACE_HOLDER.PLEASE_SELECT') },
            ],

            convertFromIDToName: convertFromIDToName,

            overlay: {
                show: false,
                variant: 'light',
                opacity: 1,
                blur: '1rem',
                rounded: 'sm',
            },

            task: {
                task_name: '',
                task_description: '',
                required_position: null,
                required_contract_type: null,
            },

            headers: [
                { text: this.$t('TASK_MANAGEMENT.TASK_NAME'), sortable: false, value: 'task_name' },
                { text: this.$t('TASK_MANAGEMENT.TASK_DESCRIPTION'), sortable: false, value: 'task_description' },
                { text: this.$t('TASK_MANAGEMENT.REQUIRED_POSITION'), sortable: false, value: 'required_position' },
                { text: this.$t('TASK_MANAGEMENT.REQUIRED_CONTRACT_TYPE'), sortable: false, value: 'required_contract_type' },
                { text: this.$t('BUTTON.ACTIONS'), sortable: false, value: 'actions' },
            ],

            items: [],

            search: '',

            search_position: '',

            modalOrganizedDate: false,

            registerDialog: false,

            editDialog: false,

            deleteDialog: false,
            deleting_id: '',

            language: this.$store.getters.language,
        };
    },
    created() {
        this.getTaskList();
        this.getPositionList();
        this.getContractType();
    },
    methods: {
        async getTaskList() {
            this.overlay.show = true;

            try {
                const response = await getAllTask(urlAPI.apiGetAllTask);

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

            this.overlay.show = false;
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

        async getSpecificTask(task_id) {
            this.task = {
                task_name: '',
                task_description: '',
                required_position: null,
                required_contract_type: null,
            };

            this.editDialog = true;

            const URL = `${urlAPI.apiGetOneTask}${task_id}`;

            try {
                const response = await getOneTask(URL);

                if (response.code === 200) {
                    this.task = response.data;
                }
            } catch (error) {
                console.log(error);
            }
        },

        openRegisterDialog() {
            this.task = {
                task_name: '',
                task_description: '',
                required_position: null,
                required_contract_type: null,
            };

            this.registerDialog = true;
        },

        async doRegisterTask() {
            try {
                const response = await createTask(urlAPI.apiCreateTask, this.task);

                if (response.code === 201) {
                    await this.getTaskList();

                    MakeToast({
                        variant: 'success',
                        title: this.$t('TOAST.TITLE.SUCCESS'),
                        content: this.$t('TOAST.CONTENT.TASK_MANAGEMENT.CREATE_TASK_SUCCESS'),
                    });

                    this.registerDialog = false;
                }
            } catch (error) {
                MakeToast({
                    variant: 'warning',
                    title: this.$t('TOAST.TITLE.WARNING'),
                    content: error || this.$t('TOAST.CONTENT.TASK_MANAGEMENT.CREATE_TASK_FAILED'),
                });

                this.registerDialog = false;
            }
        },

        async doUpdateTask(task_id) {
            const URL = `${urlAPI.apiUpdateTask}${task_id}`;

            try {
                const response = await updateTask(URL, this.task);

                if (response.code === 200) {
                    await this.getTaskList();

                    MakeToast({
                        variant: 'success',
                        title: this.$t('TOAST.TITLE.SUCCESS'),
                        content: this.$t('TOAST.CONTENT.TASK_MANAGEMENT.UPDATE_TASK_SUCCESS'),
                    });

                    this.editDialog = false;
                }
            } catch (error) {
                MakeToast({
                    variant: 'warning',
                    title: this.$t('TOAST.TITLE.WARNING'),
                    content: error || this.$t('TOAST.CONTENT.TASK_MANAGEMENT.UPDATE_TASK_FAILED'),
                });

                this.editDialog = false;
            }
        },

        async doRemoveTask(task_id) {
            const URL = `${urlAPI.apiDeleteTask}${task_id}`;

            try {
                const response = await deleteTask(URL);
                if (response.code === 200) {
                    this.getTaskList();

                    MakeToast({
                        variant: 'success',
                        title: this.$t('TOAST.TITLE.SUCCESS'),
                        content: this.$t('TOAST.CONTENT.TASK_MANAGEMENT.DELETE_TASK_SUCCESS'),
                    });

                    this.deleteDialog = false;
                }
            } catch (error) {
                MakeToast({
                    variant: 'warning',
                    title: this.$t('TOAST.TITLE.WARNING'),
                    content: error || this.$t('TOAST.CONTENT.TASK_MANAGEMENT.DELETE_TASK_FAILED'),
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
  @import '@/scss/variables.scss';

  .task-management {

    ::v-deep .v-dialog {
      overflow-y: visible;
    }

    .task-management-list-table {
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
    .task-management {
      max-height: 100%;
    }
  }
</style>
