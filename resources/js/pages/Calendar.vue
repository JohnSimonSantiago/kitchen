<template lang="">
    <Layout>
        <div>
            <h1>HAI MATAYAKON YOSHI KAYA PAY?</h1>
            <h1>From: {{this.message}}</h1>
        </div>

    </Layout>
</template>

<script>
export default {
    data(){
        return {
            message: this.$route.query.messageSent,
        };
    }
};
</script>
<style lang=""></style>
