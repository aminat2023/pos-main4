window.addEventListener('closeModel', event => {
    $("#addSection").modal('hide');
});


window.addEventListener('closeModel', event => {
  var modalElement = document.getElementById('addCategory');
  if(modalElement) {
      var modal = bootstrap.Modal.getInstance(modalElement);
      if(!modal) {
          modal = new bootstrap.Modal(modalElement);
      }
      modal.hide();
  }
});
// Success message

window.addEventListener('MSGSucesssful', event => {
    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.onmouseenter = Swal.stopTimer;
          toast.onmouseleave = Swal.resumeTimer;
        }
      });
      Toast.fire({
        icon: "success",
        title: event.detail.title
      });
});


// Delete Message
window.addEventListener('Swal:DeletedRecord', event => {
  Swal.fire({
    title: event.detail.title,
    text: event.detail.title,
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, delete it!"
  }).then((result) => {
    if (result.isConfirmed) {

      window.livewire.emit('RecordDeleted',event.detail.id)
      Swal.fire({
        title: "Deleted!",
        text: "Your file has been deleted.",
        
      });
    }
  });
})