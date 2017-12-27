<<template>
  <div class="system-setting">
    <h2>
      <router-link :to="{name:'i'}" class="backIcon">
      </router-link>
      {{language.systemSetting.accountSetting}}</h2>
    <section class="model">
      <router-link to="" class="item">
          <span class="fl">{{language.systemSetting.accountProfile}}</span>
          <i class="fr"></i></router-link>
      <router-link to="" class="item">
          <span class="fl">{{language.systemSetting.modifyPassword}}</span>
          <i class="fr"></i></router-link>
  <router-link :to="{name: 'language'}" class="multi-language">
          <span class="fl">{{language.systemSetting.language}}</span>
          <i class="fr"></i></router-link>
  <router-link to="" class="sign-out">
          <span class="fl">{{language.systemSetting.signOut}}</span>
          <i class="fr"></i></router-link>
    </section>
  </div>
</template>
<script>
  export default {
    name: 'systemSetting',
    computed: {
      language() {
        return this.$store.state.event.language
      }
    }
  }
</script>
<style scoped>
  h2 {
    text-align: center;
    line-height: 50px;
    font-size: 17px;
    color: #030303;
    font-weight: 600;
    background: #fff;
    border-bottom: 0.5px solid rgba(204, 204, 204, 0.49);
  }

  .system-setting {
    background: #ffffff;
    border-top: 0.5px solid rgba(204, 204, 204, 0.49);
  }

  .model a {
    position: relative;
    display: block;
    width: 100%;
    height: 44px;
    line-height: 44px;
    border-bottom: 0.5px solid rgba(204, 204, 204, 0.49);
    padding: 0 25px 0 15px;
  }

  .model a i {
    display: block;
    width: 30px;
    height: 30px;
  }

  .model i::after {
    display: block;
    position: absolute;
    content: "";
    width: 10px;
    height: 10px;
    border: 0.5px solid #ccc;
    border-bottom: none;
    border-left: none;
    -webkit-transform: rotate(45deg);
    transform: rotate(45deg);
    right: 10px;
    top: 17px;
  }
</style>
