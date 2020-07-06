let user = document.head.querySelector('meta[name="user"]');

export default{
  computed:{
    currentUser(){
      return JSON.parse(user.content);
    },
    isAuthenticated(){
      return !!user.content
    },
    guest(){
      return !user.content
    }
  },
  methods:{
    redirectIfGuest(){
      if(this.guest)
        return window.location.href='/login';
    }
  }
}
