<template>
	<div class="dashboard">
		<v-app>
			<v-row class="mb-3">
				<v-col cols="10">
					<v-row>
						<v-col cols="4">
							<v-card elevation="12" style="padding: 15px !important;" rounded="lg">
								<Bar
									:chart-options="chartOptions"
									:chart-data="chartData"
								/>
							</v-card>
						</v-col>

						<v-col cols="4">
							<v-card elevation="12" style="padding: 30px !important;" rounded="lg">
								<span>Second Chart</span>
							</v-card>
						</v-col>

						<v-col cols="4">
							<v-card elevation="12" style="padding: 30px !important;" rounded="lg">
								<span>Third Chart</span>
							</v-card>
						</v-col>
					</v-row>

					<v-row>
						<v-col cols="4">
							<v-card elevation="12" style="padding: 30px !important;" rounded="lg">
								<v-timeline>
									<v-timeline-item
										v-for="(year, i) in years"
										:key="i"
										:color="year.color"
										small
									>
										<template #opposite>
											<span
												:class="`headline font-weight-bold ${year.color}--text`"
												v-text="year.year"
											/>
										</template>
										<div class="py-4">
											<h5>{{ year.text }}</h5>
										</div>
									</v-timeline-item>
								</v-timeline>
							</v-card>
						</v-col>

						<v-col cols="8">
							<v-card elevation="12" style="padding: 30px !important;" rounded="lg">
								<span>Carousel</span>
							</v-card>
						</v-col>
					</v-row>
				</v-col>

				<v-col cols="2">
					<v-card elevation="12" max-width="210px" class="mx-auto py-2 px-2" max-height="700px">
						<v-img :src="link" class="mx-auto" max-height="690" />
					</v-card>
				</v-col>
			</v-row>

			<v-footer>
				<v-row>
					<v-col cols="12">
						<v-card elevation="12">
							<v-img :src="require('@/assets/images/footer.png')" />
						</v-card>
					</v-col>
				</v-row>
			</v-footer>
		</v-app>
	</div>
</template>

<script>
import { Bar } from 'vue-chartjs/legacy';
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js';
ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale);

export default {
    name: 'DashboardIndex',
    components: {
        Bar,
    },
    data() {
        return {
            img_link: '',
            isMobileMode: false,

            chartData: {
                labels: [
                    'Ban Tổ Chức',
                    'Ban An Ninh',
                    'Ban Lễ Tân',
                    'Ban Vệ Sinh',
                    'Ban Kỹ Thuật',
                    'Ban Quản Lý',
                    'Ban Dịch Vụ',
                ],
                datasets: [{
                    label: 'Xếp hạng phòng ban',
                    data: [1, 4, 3, 6, 2, 5, 7],
                    backgroundColor: [
                        '#6BCB77',
                        '#B33030',
                        '#FFD93D',
                        '#C69B7B',
                        '#B667F1',
                        '#333C83',
                        '#FAD9E6',
                    ],
                    borderColor: [
                        '#6BCB77',
                        '#B33030',
                        '#FFD93D',
                        '#C69B7B',
                        '#B667F1',
                        '#333C83',
                        '#FAD9E6',
                    ],
                    borderWidth: 1,
                }],
            },

            chartOptions: {
                responsive: true,
            },

            years: [
                {
                    color: 'cyan',
                    year: '1960',
                    text: 'Ngày Khởi Không',
                },
                {
                    color: 'green',
                    year: '1970',
                    text: 'Ngày Khánh Thành',
                },
                {
                    color: 'pink',
                    year: '1980',
                    text: 'Đón Vị Khách Đầu Tiên',
                },
                {
                    color: 'amber',
                    year: '1990',
                    text: 'Mở Chi Nhánh Thứ 2 Tại Hà Nội',
                },
                {
                    color: 'orange',
                    year: '2000',
                    text: 'Đạt Giải Homestay Đẹp Nhất 2021',
                },
            ],
        };
    },
    created() {
        window.addEventListener('resize', this.handleResizeResolution);
        this.handleResizeResolution();
        this.randomSideImage();
    },
    destroyed() {
        window.removeEventListener('resize', this.handleResizeResolution);
    },
    methods: {
        randomSideImage() {
            this.link = require('@/assets/images/art' + Math.floor((Math.random() * 12) + 1) + '.png');
        },

        handleResizeResolution() {
            var clientWidth = window.innerWidth;

            if (clientWidth <= 768) {
                this.isMobileMode = true;
            } else {
                this.isMobileMode = false;
            }
        },
    },
};
</script>

<style lang="scss" scoped>
  @import '@/scss/variables.scss';
</style>
