<template>
  <div class="col-md-12">
    <div class="panel">
      <div class="panel-heading">
        <div class="panel-title">Add New Courier</div>
      </div>
      <div class="panel-body">
        <courier-form ref="formCourier"></courier-form>
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
import { mapActions, mapState, mapMutations } from "vuex";
export default {
  name: "AddCourier",
  methods: {
    submit() {
      this.$refs.formCourier.submit();
    }
  },
  components: {
    "courier-form": FormCourier
  }
};
</script>
