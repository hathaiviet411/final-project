<template>
	<b-overlay
		:show="overlay.show"
		:variant="overlay.variant"
		:opacity="overlay.opacity"
		:blur="overlay.blur"
		:rounded="overlay.sm"
	>
		<template #overlay>
			<div class="text-center">
				<b-icon icon="arrow-clockwise" style="color: purple;" font-scale="3" animation="spin" />
				<p style="margin-top: 10px;">{{ $t('OVERLAY.PLEASE_WAIT') }}</p>
			</div>
		</template>

		<div class="main-content">
			<vHeaderPage>
				<span class="text-bold">{{ $t('ROUTER.NOTIFICATION') }}</span>
			</vHeaderPage>

			<vHeaderFilter class="mt-3">
				<template #zone-filter>
					<b-col>
						<b-row>
							<span class="text-underline cursor-pointer text-bold" @click="doClearFilter()">{{ $t('BUTTON.CLEAR_ALL') }}</span>
						</b-row>

						<b-row>
							<!-- Created Date -->
							<b-col cols="12" class="mt-3 px-0">
								<b-input-group class="created-date">
									<b-input-group-prepend is-text>
										<b-form-checkbox v-model="created_date.status" size="lg" class="filter_created_date" />
									</b-input-group-prepend>
									<b-input-group-prepend is-text>
										<span style="min-width: 125px;">{{ $t('NOTIFICATION.CREATED_DATE') }}</span>
									</b-input-group-prepend>
									<b-form-datepicker
										v-model="created_date.from"
										:label-no-date-selected="''"
										:calendar-width="`290px`"
										:date-format-options="{ year: 'numeric', month: '2-digit', day: '2-digit' }"
										:class="{ 'date_picker': true }"
										type="text"
										:locale="language"
										:disabled="!created_date.status"
										:max="created_date.to"
									>
										<template #button-content>
											<i class="fad fa-calendar-day" />
										</template>

										<template #nav-prev-month>
											<i class="fas fa-angle-left" />
										</template>

										<template #nav-next-month>
											<i class="fas fa-angle-right" />
										</template>

										<template #nav-prev-year>
											<i class="fad fa-angle-double-left" />
										</template>

										<template #nav-next-year>
											<i class="fad fa-angle-double-right" />
										</template>
									</b-form-datepicker>

									<b-input-group-prepend is-text>{{ $t('SPECIAL_CHARACTER.DASH_ARROW') }}</b-input-group-prepend>

									<b-form-datepicker
										v-model="created_date.to"
										:label-no-date-selected="''"
										:class="{ 'date_picker': true }"
										:calendar-width="`290px`"
										:date-format-options="{ year: 'numeric', month: '2-digit', day: '2-digit' }"
										type="text"
										:min="created_date.from"
										:locale="language"
										:disabled="!created_date.status"
									>
										<template #button-content>
											<i class="fad fa-calendar-day" />
										</template>

										<template #nav-prev-month>
											<i class="fas fa-angle-left" />
										</template>

										<template #nav-next-month>
											<i class="fas fa-angle-right" />
										</template>

										<template #nav-prev-year>
											<i class="fad fa-angle-double-left" />
										</template>

										<template #nav-next-year>
											<i class="fad fa-angle-double-right" />
										</template>
									</b-form-datepicker>
								</b-input-group>
							</b-col>

							<!-- Created By -->
							<b-col cols="12" class="mt-3 px-0">
								<vInputGroup
									:id="'filter-created-by'"
									v-model="created_by.value"
									:text-prepend="$t('NOTIFICATION.CREATED_BY')"
									:is-check="created_by.status"
									@isChecked="isCheckedCreatedByFilter"
								/>
							</b-col>

							<!-- Subject -->
							<b-col cols="12" class="mt-3 px-0">
								<vInputGroup
									:id="'filter-subject'"
									v-model="subject.value"
									:text-prepend="$t('NOTIFICATION.SUBJECT')"
									:is-check="subject.status"
									@isChecked="isCheckedSubjectByFilter"
								/>
							</b-col>
						</b-row>

						<b-row class="mt-3">
							<div>
								<vButton class="v-izumi-btn" :text-button="$t('BUTTON.APPLY')" @click.native="doApplyNotificationFilter()" />
							</div>
						</b-row>
					</b-col>
				</template>
			</vHeaderFilter>

			<b-row class="mt-3">
				<b-col cols="10" />

				<b-col cols="2">
					<vButton class="v-izumi-btn float-right" :text-button="$t('BUTTON.REGISTER')" @click.native="showModalRegistration()" />
				</b-col>
			</b-row>

			<div class="notification-table mt-3 px-0">
				<b-table
					striped
					hover
					bordered
					responsive="sm"
					:items="vItems"
					:fields="vFields"
				>
					<template #head()="{ field: { key }}">
						<span v-if="key === 'edit'" class="text-bold">
							{{ $t('BUTTON.EDIT') }}
						</span>

						<span v-else-if="key === 'delete'" class="text-bold">
							{{ $t('BUTTON.DELETE') }}
						</span>
					</template>

					<template #cell(edit)="edit">
						<span @click="showModalEdit(edit.item.id)">
							<i style="color: #002795;" class="fas fa-pencil-alt cursor-pointer" />
						</span>
					</template>

					<template #cell(view_number)="data">
						<b-button class="bg-tolopea" @click="showModalUnreadMessage()">
							<span>{{ data.item.view_number }}</span>
						</b-button>
					</template>

					<template #cell(delete)="remove">
						<span @click="showModalDelete(remove.item.id)">
							<i style="color: #F56C6C;" class="fas fa-trash-alt cursor-pointer" />
						</span>
					</template>

					<template #empty="">
						<span>{{ $t('TABLE.EMPTY') }}</span>
					</template>
				</b-table>
			</div>

			<div v-if="pagination.totalRows > 20" class="pagination-periodic-inspection">
				<vPagination
					:aria-controls="'table-data-list'"
					:current-page="pagination.currentPage"
					:per-page="pagination.perPage"
					:total-rows="pagination.totalRows"
					:next-class="'next'"
					:prev-class="'prev'"
					@currentPageChange="getCurrentPage"
				/>
			</div>

			<!-- Modal Delete Notification Confirmation -->
			<b-modal
				id="modal-delete-confirmation"
				v-model="isShowModalDelete"
				no-close-on-backdrop
				no-close-on-esc
				hide-header
				centered
				:static="true"
				header-class="modal-custom-header"
				content-class="modal-custom-body"
				footer-class="modal-custom-footer"
			>
				<template #default>
					<div class="text-center">
						<span class="font-weight-bold">{{ $t('MODAL.DELETE_CONFIRMATION') }}</span>
					</div>
				</template>

				<template #modal-footer>
					<b-button class="modal-btn btn-cancel bg-smalt" @click="isShowModalDelete = false">
						<i class="far fa-arrow-alt-from-right" />
						<span>{{ $t('MODAL.NO') }}</span>
					</b-button>

					<b-button class="modal-btn btn-apply bg-danger" @click="doDeleteNotification()">
						<i class="far fa-trash" />
						<span>{{ $t('MODAL.YES') }}</span>
					</b-button>
				</template>
			</b-modal>

			<!-- Modal Open Unread Message -->
			<b-modal
				id="modal-show-unread-message"
				v-model="isShowModalUnreadMessage"
				no-close-on-backdrop
				hide-header-close
				no-close-on-esc
				centered
				scrollable
				hide-footer
				size="sm"
				:static="true"
				header-class="modal-custom-header"
				content-class="modal-custom-body"
				footer-class="modal-custom-footer"
			>
				<template #modal-header>
					<div class="text-center" style="width: 100%">
						<b-row>
							<b-col cols="6" class="text-left">
								<span class="font-weight-bold">{{ $t('NOTIFICATION.UNREAD') }}</span>
							</b-col>

							<b-col cols="6" class="text-right">
								<i class="fas fa-times-circle animation-icon text-danger" @click="isShowModalUnreadMessage = false" />
							</b-col>
						</b-row>
					</div>
				</template>

				<div class="unread-message-content" style="max-height: 250px;">
					<b-row v-for="(message, index) in listUnreadMessage" :key="index">
						<b-col cols="12" class="text-center">
							<span>{{ message }}</span>
						</b-col>
					</b-row>
				</div>
			</b-modal>

			<!-- Modal Registration New Notification -->
			<b-modal
				id="modal-registration-new-notification"
				v-model="isShowModalRegistration"
				no-close-on-backdrop
				hide-header-close
				no-close-on-esc
				centered
				scrollable
				size="xl"
				:static="true"
				header-class="modal-custom-header"
				content-class="modal-custom-body"
				footer-class="modal-custom-footer"
			>
				<template #modal-header>
					<div class="text-center" style="width: 100%">
						<b-row>
							<b-col cols="6" class="text-left">
								<span class="font-weight-bold">{{ $t('NOTIFICATION.REGISTER') }}</span>
							</b-col>

							<b-col cols="6" class="text-right">
								<i class="fas fa-times-circle animation-icon" @click="isShowModalRegistration = false" />
							</b-col>
						</b-row>
					</div>
				</template>

				<template #modal-footer>
					<div class="text-center" style="width: 100%">
						<b-row>
							<b-col cols="12" class="text-left">
								<b-button class="bg-smalt modal-btn" @click="doRegister()">
									<i class="fas fa-paper-plane animation-icon" />
									<span>{{ $t('NOTIFICATION.SEND') }}</span>
								</b-button>

								<b-button class="bg-froly modal-btn" @click="selectFile()">
									<i class="fas fa-paperclip animation-icon" />
									<span>{{ $t('NOTIFICATION.ATTACH') }}</span>
								</b-button>
							</b-col>
						</b-row>
					</div>
				</template>

				<div class="main-content">
					<b-row>
						<b-col cols="12">
							<b-form-input
								v-model="notification.subject"
								:placeholder="$t('NOTIFICATION.SUBJECT')"
								type="text"
								name="notification-subject"
							/>
						</b-col>

						<b-col cols="12" class="mt-3">
							<b-form-textarea
								v-model="notification.content"
								:placeholder="$t('NOTIFICATION.CONTENT')"
								rows="20"
								max-rows="20"
								no-resize
								name="notification-content"
							/>
						</b-col>

						<b-col v-if="notification.files.length > 0" cols="12" class="mt-3 mx-auto" style="max-width: 97%;">
							<div v-for="(file, index) in notification.files" :key="index">
								<div class="mt-3 bg-light rounded-lg mx-auto" style="min-height: 45px;">
									<span class="mt-2 px-3" style="display: inline-block;">{{ file.name }}</span>
									<span>{{ `(${bytesToSize(file.size)})` }}</span>
									<i class="fas fa-trash float-right mt-3 px-3 animation-icon text-danger" @click="removeFile(file.name)" />
								</div>
							</div>
						</b-col>

						<b-col cols="12" class="mt-3">
							<b-form-file
								v-show="false"
								id="attach-file"
								ref="file-input"
								v-model="notification.files"
								multiple
							/>
						</b-col>
					</b-row>
				</div>
			</b-modal>

			<!-- Modal Edit Notification -->
			<b-modal
				id="modal-edit-notification"
				v-model="isShowModalEdit"
				no-close-on-backdrop
				hide-header-close
				no-close-on-esc
				centered
				size="xl"
				:static="true"
				header-class="modal-custom-header"
				content-class="modal-custom-body"
				footer-class="modal-custom-footer"
			>
				<template #modal-header>
					<div class="text-center" style="width: 100%">
						<b-row>
							<b-col cols="6" class="text-left">
								<span class="font-weight-bold">{{ $t('NOTIFICATION.EDIT') }}</span>
							</b-col>

							<b-col cols="6" class="text-right">
								<i class="fas fa-times-circle animation-icon" @click="isShowModalEdit = false" />
							</b-col>
						</b-row>
					</div>
				</template>

				<template #modal-footer>
					<div class="text-center" style="width: 100%">
						<b-row>
							<b-col cols="12" class="text-left">
								<b-button class="bg-smalt modal-btn" @click="doEdit()">
									<i class="fas fa-paper-plane animation-icon" />
									<span>{{ $t('BUTTON.SAVE') }}</span>
								</b-button>

								<b-button class="bg-froly modal-btn" @click="selectFile()">
									<i class="fas fa-paperclip animation-icon" />
									<span>{{ $t('NOTIFICATION.ATTACH') }}</span>
								</b-button>
							</b-col>
						</b-row>
					</div>
				</template>

				<div class="main-content">
					<b-row>
						<b-col cols="12">
							<b-form-input
								v-model="notification.subject"
								:placeholder="$t('NOTIFICATION.SUBJECT')"
								type="text"
								name="notification-subject"
							/>
						</b-col>

						<b-col cols="12" class="mt-3">
							<b-form-textarea
								v-model="notification.content"
								:placeholder="$t('NOTIFICATION.CONTENT')"
								rows="20"
								max-rows="20"
								no-resize
								name="notification-content"
							/>
						</b-col>

						<b-col v-if="notification.files.length > 0" cols="12" class="mt-3 mx-auto" style="max-width: 97%;">
							<div v-for="(file, index) in notification.files" :key="index">
								<div class="mt-3 bg-light rounded-lg mx-auto" style="min-height: 45px;">
									<span class="mt-2 px-3" style="display: inline-block;">{{ file.name }}</span>
									<span>{{ `(${bytesToSize(file.size)})` }}</span>
									<i class="fas fa-trash float-right mt-3 px-3 animation-icon text-danger" @click="removeFile(file.name)" />
								</div>
							</div>
						</b-col>

						<b-col cols="12" class="mt-3">
							<b-form-file
								v-show="false"
								id="attach-file"
								ref="file-input"
								v-model="notification.files"
								multiple
							/>
						</b-col>
					</b-row>
				</div>
			</b-modal>
		</div>
	</b-overlay>
</template>

<script>
import vHeaderFilter from '@/components/atoms/vHeaderFilter';
import vInputGroup from '@/components/atoms/vInputGroup';
import vButton from '@/components/atoms/vButton';
import vHeaderPage from '@/components/atoms/vHeaderPage';

import { validation } from './validation';
import { bytesToSize } from './helper';

export default {
    components: {
        vHeaderFilter,
        vInputGroup,
        vButton,
        vHeaderPage,
    },
    data() {
        return {
            bytesToSize: bytesToSize,

            created_date: {
                status: false,
                from: '',
                to: '',
            },

            created_by: {
                status: false,
                value: '',
            },

            subject: {
                status: false,
                value: '',
            },

            vItems: [
                {
                    created_date: '2020-01-01',
                    created_by: 'admin',
                    subject: 'test',
                    view_number: 12389,
                },
                {
                    created_date: '2020-01-02',
                    created_by: 'bdmin',
                    subject: 'test',
                    view_number: 12389,
                },
                {
                    created_date: '2020-01-03',
                    created_by: 'cdmin',
                    subject: 'test',
                    view_number: 12389,
                },
            ],

            listUnreadMessage: [
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
                '〇〇チーム　　〇〇〇〇',
            ],

            pagination: {
                currentPage: 1,
                perPage: 20,
                totalRows: 0,
            },

            overlay: {
                show: false,
                variant: 'light',
                opacity: 1,
                blur: '1rem',
                rounded: 'sm',
            },

            notification: {
                subject: '',
                content: '',
                files: [],
            },

            isShowModalDelete: false,
            isShowModalUnreadMessage: false,
            isShowModalRegistration: false,
            isShowModalEdit: false,
        };
    },
    computed: {
        language() {
            return this.$store.getters.language;
        },

        isInputFile() {
            return this.notification.files;
        },

        vFields() {
            return [
                { key: 'created_date', label: this.$t('NOTIFICATION.CREATED_DATE'), sortable: true, tdClass: 'text-center', thClass: 'text-center colorizedHeader' },
                { key: 'created_by', label: this.$t('NOTIFICATION.CREATED_BY'), sortable: true, tdClass: 'text-center', thClass: 'text-center colorizedHeader' },
                { key: 'subject', label: this.$t('NOTIFICATION.SUBJECT'), sortable: false, tdClass: 'text-center', thClass: 'text-center colorizedHeader' },
                { key: 'view_number', label: this.$t('NOTIFICATION.THE_NUMBER_OF_VIEWS'), sortable: false, tdClass: 'text-center', thClass: 'text-center colorizedHeader' },
                { key: 'edit', sortable: false, label: '', tdClass: 'text-center', thClass: 'text-center colorizedHeader' },
                { key: 'delete', sortable: false, label: '', tdClass: 'text-center', thClass: 'text-center colorizedHeader' },
            ];
        },
    },
    watch: {
        isInputFile() {
            this.handleSelectFile();
        },
    },
    methods: {
        isCheckedCreatedByFilter(data) {
            console.log('isCheckedCreatedByFilter');
        },

        isCheckedSubjectByFilter(data) {
            console.log('isCheckedSubjectByFilter');
        },

        doApplyNotificationFilter() {
            console.log('doApplyNotificationFilter');
        },

        doRegister() {
            console.log('doRegister');
            if (validation(this.notification) === true) {
                console.log('OK');
            } else {
                console.log('Error');
            }
        },

        doEdit() {
            console.log('doEdit');
            if (validation(this.notification) === true) {
                console.log('OK');
            } else {
                console.log('Error');
            }
        },

        doClearFilter() {
            console.log('doClearFilter');
        },

        doDeleteNotification(id) {
            console.log('doDeleteNotification');
        },

        showModalEdit(id) {
            this.isShowModalEdit = true;
        },

        showModalDelete() {
            this.isShowModalDelete = true;
        },

        showModalUnreadMessage() {
            this.isShowModalUnreadMessage = true;
        },

        showModalRegistration() {
            this.isShowModalRegistration = true;
        },

        selectFile() {
            document.getElementById('attach-file').click();
        },

        handleSelectFile() {
            console.log(this.notification.files);

            for (let i = 0; i < this.notification.files.length; i++) {
                this.notification.totalSize += this.notification.files[i].size;
            }
        },

        removeFile(file_name) {
            for (let i = 0; i < this.notification.files.length; i++) {
                if (this.notification.files[i].name === file_name) {
                    this.notification.files.splice(i, 1);
                }
            }
        },
    },
};
</script>

<style lang="scss" scoped>
@import '@/scss/variables.scss';

.pagination-periodic-inspection {
    display: flex;
    text-align: center;
    justify-content: center;
}

::v-deep .colorizedHeader {
    background-color: $smalt !important;
    color: $golden-tainoi !important;
}

.modal-btn {
    min-width: 120px;
}
</style>
