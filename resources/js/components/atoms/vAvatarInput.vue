<template>
	<div>
		<input ref="file" type="file" accept="image/*" class="d-none" @change="change">

		<div class="avatar-box">
			<v-img
				height="150"
				width="150"
				:src="src"
				alt="avatar"
				class="rounded-circle border border-black"
				position="center center"
			/>
		</div>

		<v-btn icon elevation="24" class="camera-button mt-3" @click="browse()">
			<v-icon small>far fa-camera-alt</v-icon>
		</v-btn>
	</div>
</template>

<script>
export default {
    name: 'VAvatarInput',
    props: {
        value: {
            type: [File, String],
            required: false,
            default: '',
        },

        defaultSrc: {
            type: String,
            required: false,
            default: '',
        },
    },
    data() {
        return {
            src: this.defaultSrc,

            file: null,
        };
    },
    methods: {
        browse() {
            this.$refs.file.click();
        },

        change(event) {
            this.file = event.target.files[0];

            this.$bus.emit('avatarChange', this.file);

            const reader = new FileReader();

            reader.readAsDataURL(this.file);

            reader.onload = (e) => {
                this.src = e.target.result;
            };
        },
    },
};
</script>

<style scoped lang="scss">
  @import '@/scss/variables.scss';

  .avatar-box {
    text-align: -webkit-center;
  }

  .camera-button {
    opacity: .6;
    bottom: 100px;
    left: 45%;
    background: $white !important;
    color: $black !important;
  }

  .camera-button:hover {
    opacity: 1 !important;
    background-color: $cloud-burst !important;
    color: white !important;
  }
</style>
