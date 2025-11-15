<style>
.admin-sidebar{
  top: 0;
  left: 0;
  height: 100vh;
  width: 260px;
  background: var(--sidebar-bg);
  border-radius: 12px;
  box-shadow: 0 8px 24px rgba(31,169,122,0.06);
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 2rem 1.5rem;
}

.admin-sidebar .brand-header{
  text-align: center;
  margin-bottom: 2rem;
}

.admin-sidebar .icon-circle{
  width: 52px;
  height: 52px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  border-radius: 14px;
  background: rgba(31,169,122,0.08);
  color: var(--brand-green);
  margin-bottom: 0.6rem;
}

.admin-sidebar .brand{
  font-weight: 800;
  color: var(--brand-green);
}

.admin-sidebar .nav-link{
  color: #0a3b2c;
  padding: .75rem 0;
  border-radius: 10px;
  display:flex;
  align-items:center;
  justify-content: center;
  gap:.6rem;
  font-weight:500;
  transition: all 0.2s ease-in-out;
}

.admin-sidebar .nav-link:hover{
  background: rgba(31,169,122,0.07);
  color: var(--brand-green);
  transform: translateX(4px);
  text-decoration: none;
}

.admin-sidebar .nav-link.active{
  background: var(--brand-green);
  color:#fff !important;
}

.icon-circle{
  width:52px; height:52px;
  display:inline-flex;
  align-items:center; justify-content:center;
  border-radius:12px;
  background: rgba(31,169,122,0.08);
}
.btn-green {
  background-color: var(--brand-green); 
  border:none; 
  border-radius:12px;
  padding:0.65rem; 
  font-weight:600; 
  transition: all 0.3s ease;
}
.btn-green:hover { 
  background-color:#188e66; 
  transform:translateY(-2px); 
}
.logout-btn { 
  width:100%; 
  margin-top:2rem; 
}
.logout-btn a { 
  text-decoration:none; 
  color: #fff; 
  display:block; 
  text-align:center; 
  font-weight:600; 
}

@media(max-width:767px){
  .admin-sidebar{
    width: 100%;
    flex-direction: row;
    justify-content: space-around;
    padding:1.5rem;
  }
  .main-content{
    padding:1rem;
  }
}
</style>

<aside class="admin-sidebar">
    <div class="brand-header">
      <div class="icon-circle"><i class="bi bi-bar-chart-line-fill"></i></div>
      <h6 class="brand mb-0">AgriLink Admin</h6>
      <small class="text-muted">Dashboard</small>
    </div>

    <ul class="nav flex-column w-100">
      <li class="nav-item"><a class="nav-link active" href="admin.php"><i class="fas fa-home"></i> Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="admin_manage_products.php"><i class="fas fa-box"></i> Manage Products</a></li>
        <li class="nav-item"><a class="nav-link" href="admin_view_users.php"><i class="fas fa-users"></i> Manage Users</a></li>
        <li class="nav-item"><a class="nav-link" href="admin_view_orders.php"><i class="fas fa-shopping-cart"></i> Manage Orders</a></li>
        <li class="nav-item"><a class="nav-link" href="admin_view_category.php"><i class="fas fa-layer-group"></i> Manage Categories</a></li>
    </ul>
    <button class="btn btn-green logout-btn">
        <a href="process/process_logout_admin.php"> Logout</a>
    </button>
  </aside>