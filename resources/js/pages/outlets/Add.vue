<template>
  <div class="col-md-12">
    <div class="panel">
      <div class="panel-heading">
        <div class="panel-title">Add New Outlet</div>
      </div>
      <div class="panel-body">
        <outlet-form></outlet-form>
        <div class="form-group">
          <button class="btn btn-primary btn-sm btn-flat" @click.prevent="submit">
            <i class="fa fa-save"></i> Add New
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { mapActions, mapState } from "vuex";
import FormOutlets from "./Form.vue";

export default {
  name: "AddOutlet",
  data() {
    return {};
  },
  methods: {
    ...mapActions("outlet", ["submitOutlet"]),
    submit() {
      this.submitOutlet().then(() => {
        this.$router.push({ name: "outlets.data" });
      });
    }
  },
  components: {
    "outlets-form": FormOutlets
  }
};
</script>
