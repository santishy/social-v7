let user = document.head.querySelector('meta[name="user"]');

module.export = {
  computed:{
    user(){
      return JSON.parse(user.content);
    }
  }
};
