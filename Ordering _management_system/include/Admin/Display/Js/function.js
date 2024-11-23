var li_items = document.querySelectorAll(".sidebar  ul li");
var hamburger= document.querySelector(".hamburger");
var wrapper = document.querySelector(".wrapper");
li_items.forEach((li_items)=>{
    li_items.addEventListener("mouseenter",()=>{
      li_items.closest(".wrapper").classList.remove("click_collapse");
     if(wrapper.classList.contains("click_collapse")){
        return
     }else{
        li_items.closest(".wrapper").classList.remove("hover_collaps");
     }
    })
    })

li_items.forEach((li_items)=>{
    li_items.addEventListener("mouseleave",()=>{
        
        if(wrapper.classList.contains("click_collapse")){
            return
        }else{
            li_items(wrapper.classList.contains.add("hover_collaps"))
        }
      })
})

hamburger.addEventListener("click",()=>{
    hamburger.closest(".wrapper").classList.toggle("click_collapse");
    hamburger.closest(".wrapper").classList.toggle("hover_collaps");

})
  




