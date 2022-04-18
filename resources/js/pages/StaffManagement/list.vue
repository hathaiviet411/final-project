<template>
	<div class="staff-management">
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
											<span style="color: #FFFFFF;">{{ $t('STAFF_MANAGEMENT.NEW_STAFF') }}</span>
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
    name: 'StaffManagementList',
    data() {
        return {
            StaffList: [],

            overlay: {
                show: false,
                variant: 'light',
                opacity: 1,
                blur: '1rem',
                rounded: 'sm',
            },

            headers: [
                { text: this.$t('STAFF_MANAGEMENT.STAFF_CODE') + ' ⇅', sortable: true, value: 'staff_code' },
                { text: this.$t('STAFF_MANAGEMENT.FULL_NAME') + ' ⇅', sortable: true, value: 'full_name' },
                { text: this.$t('STAFF_MANAGEMENT.EMAIL'), sortable: false, value: 'email' },
                { text: this.$t('STAFF_MANAGEMENT.DEPARTMENT') + ' ⇅', sortable: true, value: 'department' },
                { text: this.$t('STAFF_MANAGEMENT.ROLE') + ' ⇅', sortable: true, value: 'role' },
                { text: this.$t('STAFF_MANAGEMENT.POSITION') + ' ⇅', sortable: true, value: 'position' },
                { text: this.$t('STAFF_MANAGEMENT.PHONE_NUMBER'), sortable: false, value: 'phone_number' },
                { text: this.$t('STAFF_MANAGEMENT.IS_RETIRED') + ' ⇅', sortable: true, value: 'is_retired' },
            ],

            items: [
                {
                    staff_code: 123124,
                    full_name: 'Nguyễn Văn Cừ',
                    email: 'nguyenvancu@gmail.com',
                    department: 'Ban Lễ Tân',
                    role: 'Nhân viên',
                    position: 'Nhân viên lễ tân',
                    phone_number: '0987654321',
                    is_retired: 'Đang làm việc',
                },
                {
                    staff_code: 789124,
                    full_name: 'Nguyễn Bảo Linh',
                    email: 'nguyenbaolinh@gmail.com',
                    department: 'Ban vệ sinh',
                    role: 'Nhân viên',
                    position: 'Nhân viên vệ sinh phòng',
                    phone_number: '0987654321',
                    is_retired: 'Đã nghĩ việc',
                },
                {
                    staff_code: 123612,
                    full_name: 'Nguyễn Văn Cừ',
                    email: 'nguyenvancu@gmail.com',
                    department: 'Ban Lễ Tân',
                    role: 'Nhân viên',
                    position: 'Nhân viên lễ tân',
                    phone_number: '0987654321',
                    is_retired: 'Đang làm việc',
                },
                {
                    staff_code: 612442,
                    full_name: 'Nguyễn Bảo Linh',
                    email: 'nguyenbaolinh@gmail.com',
                    department: 'Ban vệ sinh',
                    role: 'Nhân viên',
                    position: 'Nhân viên vệ sinh phòng',
                    phone_number: '0987654321',
                    is_retired: 'Đã nghĩ việc',
                },
                {
                    staff_code: 973123,
                    full_name: 'Nguyễn Văn Cừ',
                    email: 'nguyenvancu@gmail.com',
                    department: 'Ban Lễ Tân',
                    role: 'Nhân viên',
                    position: 'Nhân viên lễ tân',
                    phone_number: '0987654321',
                    is_retired: 'Đang làm việc',
                },
                {
                    staff_code: 512372,
                    full_name: 'Nguyễn Bảo Linh',
                    email: 'nguyenbaolinh@gmail.com',
                    department: 'Ban vệ sinh',
                    role: 'Nhân viên',
                    position: 'Nhân viên vệ sinh phòng',
                    phone_number: '0987654321',
                    is_retired: 'Đã nghĩ việc',
                },
            ],

            search: '',

            language: this.$store.getters.language,
        };
    },
    created() {
        this.getStaffList();
    },
    methods: {
        getStaffList() {
            console.log('Get Staff List');
        },
    },
};
</script>

<style lang="scss" scoped>
  @import "@/scss/variables.scss";

  .staff-management {
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
