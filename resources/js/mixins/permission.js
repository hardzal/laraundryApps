export default {
    methods: {
        $can(permsissonName) {
            let Permission = this.$store.state.user.authenticated.permissions;
            if (typeof Permission != 'undefined') {
                return Permission.indexOf(permsissonName) !== -1;
            }
        }
    }
}
