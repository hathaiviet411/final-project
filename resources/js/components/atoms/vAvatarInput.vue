<template>
	<div>
		<input ref="file" type="file" accept="image/*" class="d-none" @change="change">

		<v-img
			height="150"
			width="150"
			:src="src"
			alt="avatar"
			class="rounded-circle"
			position="center center"
		/>

		<v-btn class="primary-btn mt-3" @click="browse()">
			<span>Browse</span>
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

            this.$emit('input', this.file);

            const reader = new FileReader();

            reader.readAsDataURL(this.file);

            reader.onload = (e) => {
                this.src = e.target.result;
            };
        },
    },
};
</script>

<style>

</style>
