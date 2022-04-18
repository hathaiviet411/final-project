<template>
	<div class="job-management">
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
											<span style="color: #FFFFFF;">{{ $t('JOB_MANAGEMENT.NEW_JOB') }}</span>
										</v-btn>
									</v-col>
								</v-row>
							</v-card-title>

							<v-data-table
								:headers="headers"
								:items="items"
								:search="search"
								item-key="staff_name"
								sort-by="staff_name"
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
    name: 'JobManagementIndex',
    data() {
        return {
            RoomList: [],

            overlay: {
                show: false,
                variant: 'light',
                opacity: 1,
                blur: '1rem',
                rounded: 'sm',
            },

            headers: [
                { text: this.$t('JOB_MANAGEMENT.JOB_NAME') + ' ⇅', sortable: true, value: 'job_name' },
                { text: this.$t('JOB_MANAGEMENT.JOB_DESCRIPTION'), sortable: false, value: 'job_description' },
                { text: this.$t('JOB_MANAGEMENT.REQUIRED_POSITION') + ' ⇅', sortable: true, value: 'required_position' },
                { text: this.$t('JOB_MANAGEMENT.REQUIRED_CONTRACT_TYPE') + ' ⇅', sortable: true, value: 'required_contract_type' },
            ],

            items: [
                {
                    job_name: 'Tiếp khách',
                    job_description: 'Đứng ở sảnh đón tiếp khách, yêu cầu luôn vui tươi mỉm cười, thái độ thân thiện, hài hoà.',
                    required_position: 'Nhân viên',
                    required_contract_type: 'Nhân viên chính thức',
                },
                {
                    job_name: 'Dọn vệ sinh',
                    job_description: 'Dọn dẹp phòng ở của khách hàng.',
                    required_position: 'Nhân viên',
                    required_contract_type: 'Nhân viên bán thời gian',
                },
                {
                    job_name: 'Nghiệm thu vệ sinh phòng',
                    job_description: 'Kiểm tra các vệ sinh của các phòng, đảm bảo nhân viên vệ sinh phòng đã hoàn thành công việc.',
                    required_position: 'Quản lí',
                    required_contract_type: 'Nhân viên chính thức',
                },
            ],

            search: '',

            language: this.$store.getters.language,
        };
    },
    created() {
        this.getJobList();
    },
    methods: {
        getJobList() {
            console.log('Get Job List');
        },
    },
};
</script>

<style lang="scss" scoped>
  @import '@/scss/variables.scss';

  .job-management {
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
