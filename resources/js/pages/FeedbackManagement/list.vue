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
						<v-card elevation="24" min-height="700">
							<v-card-title>
								<v-row>
									<v-col lg="10" sm="12">
										<v-text-field
											v-model="search"
											append-icon="mdi-magnify"
											:label="$t('BUTTON.SEARCH')"
											single-line
											hide-details
										/>
									</v-col>

									<v-col lg="2" sm="12" class="text-center">
										<v-btn color="#1e2a55" dark class="mt-3">
											<span style="color: #FFFFFF;">{{ $t('FEEDBACK_MANAGEMENT.NEW_FEEDBACK') }}</span>
										</v-btn>
									</v-col>
								</v-row>
							</v-card-title>

							<v-data-table
								:headers="headers"
								:items="items"
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
							/>
						</v-card>
					</v-col>
				</v-row>
			</b-overlay>
		</v-app>
	</div>
</template>

<script>
export default {
    name: 'FeedbackManagementList',
    data() {
        return {
            FacilityList: [],

            overlay: {
                show: false,
                variant: 'light',
                opacity: 1,
                blur: '1rem',
                rounded: 'sm',
            },

            headers: [
                { text: this.$t('FEEDBACK_MANAGEMENT.FEEDBACK_TITLE') + ' ⇅', sortable: true, value: 'feedback_title' },
                { text: this.$t('FEEDBACK_MANAGEMENT.FEEDBACK_CONTENT') + ' ⇅', sortable: true, value: 'feedback_content' },
                { text: this.$t('FEEDBACK_MANAGEMENT.UPLOADED_DATE') + ' ⇅', sortable: true, value: 'uploaded_date' },
                { text: this.$t('FEEDBACK_MANAGEMENT.SUBJECT') + ' ⇅', sortable: true, value: 'subject' },
                { text: this.$t('FEEDBACK_MANAGEMENT.USER_NAME') + ' ⇅', sortable: true, value: 'user_name' },
                { text: this.$t('FEEDBACK_MANAGEMENT.DEPARTMENT') + ' ⇅', sortable: true, value: 'department' },
                { text: this.$t('FEEDBACK_MANAGEMENT.POSITION') + ' ⇅', sortable: true, value: 'position' },
            ],

            items: [
                {
                    feedback_title: 'Feedback Title',
                    feedback_content: 'Feedback Content',
                    uploaded_date: 'Uploaded Date',
                    subject: 'Subject',
                    user_name: 'User Name',
                    department: 'Department',
                    position: 'Position',
                },
                {
                    feedback_title: 'Feedback Title',
                    feedback_content: 'Feedback Content',
                    uploaded_date: 'Uploaded Date',
                    subject: 'Subject',
                    user_name: 'User Name',
                    department: 'Department',
                    position: 'Position',
                },
                {
                    feedback_title: 'Feedback Title',
                    feedback_content: 'Feedback Content',
                    uploaded_date: 'Uploaded Date',
                    subject: 'Subject',
                    user_name: 'User Name',
                    department: 'Department',
                    position: 'Position',
                },
            ],

            search: '',

            language: this.$store.getters.language,
        };
    },
    created() {
        this.getFeedbackList();
    },
    methods: {
        getFeedbackList() {
            console.log('Get Feedback List');
        },
    },
};
</script>

<style lang="scss" scoped>
  @import "@/scss/variables.scss";

  .feedback-management {
    ::v-deep th {
      font-size: 14px !important;
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
</style>
