



<style>


  
  :root {
    --main-bg-color: #009d63;
    --main-text-color: #009d63;
    --second-text-color: #bbbec5;
    --second-bg-color: #c1efde;
  }
  
  .primary-text {
    color: var(--main-text-color);
  }
  
  .second-text {
    color: var(--second-text-color);
  }
  
  .primary-bg {
    background-color: var(--main-bg-color);
  }
  
  .secondary-bg {
    background-color: var(--second-bg-color);
  }
  
  .rounded-full {
    border-radius: 100%;
  }
  
  #wrapper {
    overflow-x: hidden;
    
   background-image: linear-gradient(to right, #4facfe 0%, #00f2fe 100%);;
  }
  
  #sidebar-wrapper {
    min-height: 100vh;
    margin-left: -15rem;
    -webkit-transition: margin 0.25s ease-out;
    -moz-transition: margin 0.25s ease-out;
    -o-transition: margin 0.25s ease-out;
    transition: margin 0.25s ease-out;
  }
  
  #sidebar-wrapper .sidebar-heading {
    padding: 0.875rem 1.25rem;
    font-size: 1.2rem;
  }
  
  #sidebar-wrapper .list-group {
    width: 15rem;
  }
  
  #page-content-wrapper {
    min-width: 100vw;
  }
  
  #wrapper.toggled #sidebar-wrapper {
    margin-left: 0;
  }
  
  #menu-toggle {
    cursor: pointer;
  }
  
  .list-group-item {
    border: none;
    padding: 10px 30px;
     color: #000;
  }
  
  .list-group-item.active {
    background-color: transparent;
    color: var(--main-text-color);
    font-weight: bold;
    border: none;
  }
  
  @media (min-width: 768px) {
    #sidebar-wrapper {
      margin-left: 0;
    }
  
    #page-content-wrapper {
      min-width: 0;
      width: 100%;
    }
  
    #wrapper.toggled #sidebar-wrapper {
      margin-left: -15rem;
    }
  }
  
</style>







<div class="bg-white" id="sidebar-wrapper">
            <div class="sidebar-heading text-center py-4 primary-text fs-4 fw-bold text-uppercase border-bottom">
                  <img src="image/chantong.jpg" alt=""> </i>OO-MS</div>
            <div class="list-group list-group-flush my-3">
                <a href="index.php" class="list-group-item list-group-item-action bg-transparent second-text active"><i
                        class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
                <a href="admin.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">Users</a>
               
                <a href="view-customer.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">Customers</a>
                <a href="orders.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">Orders</a>

                        <a href="product_price.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">Product</a>


                        <a href="branch.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">Branch</a>
                <a href="category.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">Category</a>
                <a href="size.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">
                   Size</a>
                
                  <!-- Include Bootstrap CSS -->


<!-- Dropdown -->
<div class="dropdown">
  <a 
    class="list-group-item list-group-item-action bg-transparent second-text fw-bold dropdown-toggle" 
    href="#" 
    role="button" 
    id="dropdownMenuLink" 
    data-bs-toggle="dropdown" 
    aria-expanded="false">
    Payment
  </a>
  <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
    <li><a class="dropdown-item" href="payment.php">Payment Type</a></li>
    <li><a class="dropdown-item" href="payment-history.php">Payment method</a></li>
  
  </ul>
</div>

<!-- Include Bootstrap JS -->


                            
              
                            <a href="Sales.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">Sales</a>
                            
                            <a href="Sales.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">Inventory</a>
                            
                            <a href="Sales.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">Calendar Event</a>
                            
                            <a href="Sales.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">Feedback</a>
                            <a href="Sales.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"> Report</a>
                            
                        
            </div>

            
        </div>

        
       

        <!-- /#sidebar-wrapper -->