
.glass-navbar {
background: rgba(255, 255, 255, 0.2); /* transparent white overlay */
backdrop-filter: blur(10px); /* blur behind */
-webkit-backdrop-filter: blur(10px); /* Safari support */
border-bottom: 1px solid rgba(255, 255, 255, 0.3);
box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}
.bar .bar-link {
  color: #2e7d32 !important; /* dark green for contrast */
  font-weight: 500;
  text-decoration: none;
}
.bar .bar-link:hover {
  color: #1b5e20 !important;
}
.bar .button {
  border-radius: 10px;
  backdrop-filter: blur(5px);
}
.hero {
  background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url("../assets/images/index.png");
  background-size: cover;
  background-position: center;
  padding: 80px 0;
  margin-top: 6%;
}
.card-style-1 .card-meta .image {
  max-width: 40px;
  width: 100%;
  border-radius: 50%;
  overflow: hidden;
  margin-right: 12px;
}
.card-style-1 .card-meta .image img {
  width: 100%;
}
@keyframes fadeIn { 
        from{opacity:0; 
          transform:translateY(10px);} to{opacity:1; transform:translateY(0);
        } 
      }
