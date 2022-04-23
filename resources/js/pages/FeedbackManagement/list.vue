<template>
	<div class="feedback-management">
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
							<v-card-title><b-row>
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
										<span>{{ $t('FEEDBACK_MANAGEMENT.NEW_FEEDBACK') }}</span>
									</v-btn>
								</b-col>
							</b-row>
							</v-card-title>

							<v-data-table
								class="feedback-management-list-table mt-3"
								:headers="headers"
								:items="items"
								item-key="feedback_name"
								:search="search"
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
								<template #[`item.upload_date`]="{ item }">
									<span class="d-block" style="min-width: 150px">{{ (item.upload_date).split(' ')[0] }}</span>
								</template>

								<template #[`item.status`]="{ item }">
									<span v-if="item.status === 1" class="d-block" style="min-width: 100px">
										<v-icon small class="mr-3">fab fa-stack-overflow</v-icon>
										{{ $t('FEEDBACK_MANAGEMENT.STATUS.PENDING') }}
									</span>

									<span v-else-if="item.status === 2" class="d-block" style="min-width: 100px">
										<v-icon small class="mr-3">fas fa-hourglass-half</v-icon>
										{{ $t('FEEDBACK_MANAGEMENT.STATUS.PROCESSING') }}
									</span>

									<span v-else-if="item.status === 3" class="d-block" style="min-width: 100px">
										<v-icon small class="mr-3">fas fa-door-closed</v-icon>
										{{ $t('FEEDBACK_MANAGEMENT.STATUS.CLOSED') }}
									</span>

									<span v-else-if="item.status === 4" class="d-block" style="min-width: 100px">
										<v-icon small class="mr-3">fas fa-times-circle</v-icon>
										{{ $t('FEEDBACK_MANAGEMENT.STATUS.CANCELED') }}
									</span>
								</template>

								<template #[`item.actions`]="{ item }">
									<v-row>
										<v-col cols="6" class="text-right">
											<v-icon small class="text-primary" @click="getSpecificFeedback(item.id)">fas fa-edit</v-icon>
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
							<span>{{ $t('FEEDBACK_MANAGEMENT.NEW_FEEDBACK') }}</span>
						</v-btn>

						<v-card-text>
							<v-row class="mt-1">
								<v-col cols="12">
									<v-text-field
										v-model="feedback.feedback_title"
										:label="$t('FEEDBACK_MANAGEMENT.FEEDBACK_TITLE')"
										outlined
									/>
								</v-col>

								<v-col cols="12">
									<v-textarea
										v-model="feedback.feedback_content"
										outlined
										no-resize
										:label="$t('FEEDBACK_MANAGEMENT.FEEDBACK_CONTENT')"
									/>
								</v-col>

								<v-col cols="12">
									<v-text-field
										v-model="feedback.subject"
										outlined
										:label="$t('FEEDBACK_MANAGEMENT.SUBJECT')"
									/>
								</v-col>

								<v-col v-if="role !== 'staff'" cols="12">
									<v-select
										v-model="feedback.status"
										:items="statusList"
										:label="$t('FEEDBACK_MANAGEMENT.STATUS.STATUS')"
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
									<v-btn class="primary-btn" @click="doRegisterFeedback()">
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
							<span>{{ $t('FEEDBACK_MANAGEMENT.EDIT_FEEDBACK') }}</span>
						</v-btn>

						<v-card-text>
							<v-row class="mt-1">
								<v-col cols="12">
									<v-text-field
										v-model="feedback.feedback_title"
										:label="$t('FEEDBACK_MANAGEMENT.FEEDBACK_TITLE')"
										outlined
									/>
								</v-col>

								<v-col cols="12">
									<v-textarea
										v-model="feedback.feedback_content"
										outlined
										no-resize
										:label="$t('FEEDBACK_MANAGEMENT.FEEDBACK_CONTENT')"
									/>
								</v-col>

								<v-col cols="12">
									<v-text-field
										v-model="feedback.subject"
										outlined
										:label="$t('FEEDBACK_MANAGEMENT.SUBJECT')"
									/>
								</v-col>

								<v-col v-if="role !== 'staff'" cols="12">
									<v-select
										v-model="feedback.status"
										:items="statusList"
										:label="$t('FEEDBACK_MANAGEMENT.STATUS.STATUS')"
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
									<v-btn class="primary-btn" @click="doUpdateFeedback(feedback.id)">
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
							<span>{{ $t('FEEDBACK_MANAGEMENT.DELETE_FEEDBACK') }}</span>
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
									<v-btn class="danger-btn" @click="doRemoveFeedback(deleting_id)">
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

<script>import {
    getAllFeedback,
    getOneFeedback,
    createFeedback,
    updateFeedback,
    deleteFeedback,
}
from '@/api/modules/Feedback';

import { MakeToast } from '@/utils/MakeToast';

const urlAPI = {
    apiGetAllFeedback: '/feedback/list',
    apiGetOneFeedback: '/feedback/detail/',
    apiCreateFeedback: '/feedback/create',
    apiUpdateFeedback: '/feedback/update/',
    apiDeleteFeedback: '/feedback/delete/',
};

export default {
    name: 'FeedbackManagementList',
    data() {
        return {
            overlay: {
                show: false,
                variant: 'light',
                opacity: 1,
                blur: '1rem',
                rounded: 'sm',
            },

            feedback: {
                feedback_title: '',
                feedback_content: '',
                subject: '',
                status: null,
            },

            headers: [
                { text: this.$t('FEEDBACK_MANAGEMENT.FEEDBACK_TITLE'), sortable: false, value: 'feedback_title' },
                { text: this.$t('FEEDBACK_MANAGEMENT.FEEDBACK_CONTENT'), sortable: false, value: 'feedback_content' },
                { text: this.$t('FEEDBACK_MANAGEMENT.UPLOADED_DATE'), sortable: false, value: 'upload_date' },
                { text: this.$t('FEEDBACK_MANAGEMENT.SUBJECT'), sortable: false, value: 'subject' },
                { text: this.$t('FEEDBACK_MANAGEMENT.USER_NAME'), sortable: false, value: 'user.user_name' },
                { text: this.$t('FEEDBACK_MANAGEMENT.DEPARTMENT'), sortable: false, value: 'user.department.department_name' },
                { text: this.$t('FEEDBACK_MANAGEMENT.POSITION'), sortable: false, value: 'position_id' },
                { text: this.$t('FEEDBACK_MANAGEMENT.STATUS.STATUS'), sortable: false, value: 'status' },
                { text: this.$t('BUTTON.ACTIONS'), sortable: false, value: 'actions' },
            ],

            items: [],

            statusList: [
                { text: this.$t('PLACE_HOLDER.PLEASE_SELECT'), value: null },
                { text: this.$t('FEEDBACK_MANAGEMENT.STATUS.PENDING'), value: 1 },
                { text: this.$t('FEEDBACK_MANAGEMENT.STATUS.PROCESSING'), value: 2 },
                { text: this.$t('FEEDBACK_MANAGEMENT.STATUS.CLOSED'), value: 3 },
                { text: this.$t('FEEDBACK_MANAGEMENT.STATUS.CANCELED'), value: 4 },
            ],

            search: '',

            registerDialog: false,

            editDialog: false,

            deleteDialog: false,
            deleting_id: '',

            language: this.$store.getters.language,
        };
    },
    computed: {
        role() {
            return this.$store.getters.roles[0];
        },
    },
    created() {
        this.getFeedbackList();
    },
    methods: {
        async getFeedbackList() {
            this.overlay.show = true;

            try {
                const response = await getAllFeedback(urlAPI.apiGetAllFeedback);

                console.log(response);

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

        async getSpecificFeedback(feedback_id) {
            this.feedback = {
                feedback_title: '',
                feedback_content: '',
                upload_date: '',
                subject: '',
                status: null,
            };

            this.editDialog = true;

            const URL = `${urlAPI.apiGetOneFeedback}${feedback_id}`;

            try {
                const response = await getOneFeedback(URL);

                if (response.code === 200) {
                    this.feedback = response.data;
                }
            } catch (error) {
                console.log(error);
            }
        },

        openRegisterDialog() {
            this.feedback = {
                feedback_title: '',
                feedback_content: '',
                upload_date: '',
                subject: '',
                status: null,
            };

            this.registerDialog = true;
        },

        async doRegisterFeedback() {
            if (this.role === 'staff') {
                this.feedback.status = 1;
            }

            this.feedback.upload_date = new Date().toISOString();

            try {
                const response = await createFeedback(urlAPI.apiCreateFeedback, this.feedback);

                if (response.code === 201) {
                    await this.getFeedbackList();

                    MakeToast({
                        variant: 'success',
                        title: this.$t('TOAST.TITLE.SUCCESS'),
                        content: this.$t('TOAST.CONTENT.FEEDBACK_MANAGEMENT.CREATE_FEEDBACK_SUCCESS'),
                    });

                    this.registerDialog = false;
                }
            } catch (error) {
                MakeToast({
                    variant: 'warning',
                    title: this.$t('TOAST.TITLE.WARNING'),
                    content: error || this.$t('TOAST.CONTENT.FEEDBACK_MANAGEMENT.CREATE_FEEDBACK_FAILED'),
                });

                this.registerDialog = false;
            }
        },

        async doUpdateFeedback(feedback_id) {
            const URL = `${urlAPI.apiUpdateFeedback}${feedback_id}`;

            if (this.role === 'staff') {
                this.feedback.status = 1;
            }

            this.feedback.upload_date = new Date().toISOString();

            try {
                const response = await updateFeedback(URL, this.feedback);

                if (response.code === 200) {
                    await this.getFeedbackList();

                    MakeToast({
                        variant: 'success',
                        title: this.$t('TOAST.TITLE.SUCCESS'),
                        content: this.$t('TOAST.CONTENT.FEEDBACK_MANAGEMENT.UPDATE_FEEDBACK_SUCCESS'),
                    });

                    this.editDialog = false;
                }
            } catch (error) {
                MakeToast({
                    variant: 'warning',
                    title: this.$t('TOAST.TITLE.WARNING'),
                    content: error || this.$t('TOAST.CONTENT.FEEDBACK_MANAGEMENT.UPDATE_FEEDBACK_FAILED'),
                });

                this.editDialog = false;
            }
        },

        async doRemoveFeedback(feedback_id) {
            const URL = `${urlAPI.apiDeleteFeedback}${feedback_id}`;

            try {
                const response = await deleteFeedback(URL);
                if (response.code === 200) {
                    this.getFeedbackList();

                    MakeToast({
                        variant: 'success',
                        title: this.$t('TOAST.TITLE.SUCCESS'),
                        content: this.$t('TOAST.CONTENT.FEEDBACK_MANAGEMENT.DELETE_FEEDBACK_SUCCESS'),
                    });

                    this.deleteDialog = false;
                }
            } catch (error) {
                MakeToast({
                    variant: 'warning',
                    title: this.$t('TOAST.TITLE.WARNING'),
                    content: error || this.$t('TOAST.CONTENT.FEEDBACK_MANAGEMENT.DELETE_FEEDBACK_FAILED'),
                });

                this.deleteDialog = false;
            }
        },
    },
};
</script>

<style lang="scss" scoped>
  @import "@/scss/variables.scss";

  .feedback-management {
    ::v-deep .v-dialog {
      overflow-y: visible;
    }

    .feedback-management-list-table {
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
    .feedback-management {
      max-height: 100%;
    }
  }
</style>
