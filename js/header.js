window.addEventListener('pageshow',()=>{
    if(window.performance.navigation.type==2) location.reload();
  });