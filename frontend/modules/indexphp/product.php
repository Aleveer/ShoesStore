<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../../templates/css/product_slider.css">
    <link rel="stylesheet" href="../../templates/css/product.css">
</head>
<body>
    <div class="carousel">
        <div class="list">
            <div class="item active">
                <img src="../../templates/images/680098.jpg" alt="">
                <div class="content">
                    <div class="author">My Shoes Store</div>
                    <div class="title">FILLO</div>
                    <div class="topic">Introduce</div>
                    <div class="des">
                        Nơi mà niềm đam mê thể thao và phong cách thời trang hiện đại hòa quyện.
                        Không chỉ là một điểm bán giày, mà còn là nguồn cảm hứng cho những người yêu thể thao.   
                    </div>
                    <div class="buttons">
                        <button>SUBCRIBE</button>
                        <button>CONTACT US</button>
                    </div>
                </div>
            </div>

            <div class="item">
                <img src="../../templates/images/680102.jpg" alt="">
                <div class="content">
                    <div class="author">My Shoes Store</div>
                    <div class="title">FILLO</div>
                    <div class="topic">Introduce</div>
                    <div class="des">
                        Cam kết mang đến cho bạn những đôi giày chất lượng cao, từ các thương hiệu nổi tiếng như Nike, 
                        Adidas, và Puma, đến những thương hiệu mới nổi đầy sáng tạo.
                    </div>
                    <div class="buttons">
                        <button>SUBCRIBE</button>
                        <button>CONTACT US</button>
                    </div>
                </div>
            </div>

            <div class="item">
                <img src="../../templates/images/Air-Jordan-Shoes-Photo.jpg" alt="">
                <div class="content">
                    <div class="author">My Shoes Store</div>
                    <div class="title">FILLO</div>
                    <div class="topic">Introduce</div>
                   <div class="des">
                    Mỗi đôi giày tại cửa hàng đều được chọn lọc kỹ càng, đảm bảo sự thoải mái, độ bền và phong cách. 
                    Với đa dạng mẫu mã và màu sắc, bạn chắc chắn sẽ tìm thấy đôi giày phù hợp với mình.
                   </div>
                   <div class="buttons">
                        <button>SUBCRIBE</button>
                        <button>CONTACT US</button>
                    </div>
                </div>
            </div>

            <div class="item">
                <img src="../../templates/images/Air-Jordan-Shoes-Picture.jpg" alt="">
                <div class="content">
                    <div class="author">My Shoes Store</div>
                    <div class="title">FILLO</div>
                    <div class="topic">Introduce</div>
                    <div class="des">
                        Đội ngũ nhân viên thân thiện và chuyên nghiệp của chúng tôi luôn sẵn sàng tư vấn để bạn có thể chọn được đôi giày tốt nhất.
                         Chính sách đổi trả linh hoạt và dịch vụ sau bán hàng chu đáo sẽ làm bạn hài lòng.
                    </div>
                    <div class="buttons">
                        <button>SUBCRIBE</button>
                        <button>CONTACT US</button>
                    </div>
                </div>
            </div>

        </div>

        <div class="thumbnail">
            <div class="item">
                <img src="../../templates/images/680102.jpg" alt="">
                <div class="content">
                    <div class="title">FILLO</div>
                    <div class="des">Tôn Chỉ</div>
                </div>
            </div>

            <div class="item">
                <img src="../../templates/images/Air-Jordan-Shoes-Photo.jpg" alt="">
                <div class="content">
                    <div class="title">FILLO</div>
                    <div class="des">Đặc Điểm</div>
                </div>
            </div>

            <div class="item">
                <img src="../../templates/images/Air-Jordan-Shoes-Picture.jpg" alt="">
                <div class="content">
                    <div class="title">FILLO</div>
                    <div class="des">Dịch Vụ</div>
                </div>
            </div>

            <div class="item active">
                <img src="../../templates/images/680098.jpg" alt="">
                <div class="content">
                    <div class="title">FILLO</div>
                    <div class="des">FILLO Slogan</div>
                </div>
            </div>
        </div>

        <div class="arrows">
            <button id="prev"><</button>
            <button id="next">></button>
        </div>
       

    </div>

    <div class="con_product">
        <div class="psearch">
            <input type="text" placeholder="Nhập sản phẩm bạn muốn tìm kiếm">
            <button class=" custom-btn btn-14"><i class="fa-solid fa-magnifying-glass"></i></button>
        </div>

        <div class="container_filter_pagination">
            <div class="filter">
               <fieldset>
                    <legend>Category</legend>
                    <input type="radio" name="category" checked >All products
                    <br>
                    <input type="radio" name="category" >Basketball Shoes
                    <br>
                    <input type="radio" name="category" >Running Shoes
                    <br>
                    <input type="radio" name="category" >Tennis
                    <br>
                    <input type="radio" name="category" >Trail Running Shoes
                    <br>
                    <input type="radio" name="category" >Walking Shoes
               </fieldset>
                <fieldset>
                    <legend>Gender</legend>
                    <input type="radio" name="gender" >Male
                    <br>
                    <input type="radio" name="gender" >Female
                </fieldset>
                <fieldset>
                    <legend>Price</legend>
                    <label for="price">Price:</label>
                    <input type="number" name="price" min="100000" placeholder="100000">
                </fieldset>
            </div> 
            <div class="container_pagination">
                <div class="areaproduct">
                    <div class="pitem">
                        <div class="imgitem">
                            <img src="../../../img/Basketball Shoes/Adidas Dame 7.avif" alt="">
                        </div>
                        <div class="content">
                            <div class="name">Adidas Dame 7</div>
                            <div class="price">100.000 <sup>đ</sup></div>
                            <button class="see_product" >
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <a href="">SEE MORE</a>
                            </button>
                        </div> 
                    </div>
                    <div class="pitem">
                        <div class="imgitem">
                            <img src="../../../img/Basketball Shoes/Adidas Harden Stepback.avif" alt="">
                        </div>
                        <div class="content">
                            <div class="name">Adidas Harden Stepback </div>
                            <div class="price">100.000 <sup>đ</sup></div>
                            <button class="see_product" >
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <a href="">SEE MORE</a>
                            </button>
                        </div> 
                    </div>
                    <div class="pitem">
                        <div class="imgitem">
                            <img src="../../../img/Basketball Shoes/Adidas N3XT L3V3L 2022.avif" alt="">
                        </div>
                        <div class="content">
                            <div class="name">Adidas N3XT L3V3L 2022</div>
                            <div class="price">100.000 <sup>đ</sup></div>
                            <button class="see_product" >
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <a href="">SEE MORE</a>
                            </button>
                        </div> 
                    </div>
                    <div class="pitem">
                        <div class="imgitem">
                            <img src="../../../img/Basketball Shoes/New Balance Kawhi Leonard 1.avif" alt="">
                        </div>
                        <div class="content">
                            <div class="name">New Balance Kawhi Leonard 1</div>
                            <div class="price">100.000 <sup>đ</sup></div>
                            <button class="see_product" >
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <a href="">SEE MORE</a>
                            </button>
                        </div> 
                    </div>
                    <div class="pitem">
                        <div class="imgitem">
                            <img src="../../../img/Basketball Shoes/Nike Kyrie 7.avif" alt="">
                        </div>
                        <div class="content">
                            <div class="name">Nike Kyrie 7</div>
                            <div class="price">100.000 <sup>đ</sup></div>
                            <button class="see_product" >
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <a href="">SEE MORE</a>
                            </button>
                        </div> 
                    </div>
                    <div class="pitem">
                        <div class="imgitem">
                            <img src="../../../img/Basketball Shoes/Nike LeBron 19.avif" alt="">
                        </div>
                        <div class="content">
                            <div class="name">Nike LeBron 19</div>
                            <div class="price">100.000 <sup>đ</sup></div>
                            <button class="see_product" >
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <a href="">SEE MORE</a>
                            </button>
                        </div> 
                    </div>
                    <div class="pitem">
                        <div class="imgitem">
                            <img src="../../../img/Basketball Shoes/Nike PG 5.avif" alt="">
                        </div>
                        <div class="content">
                            <div class="name">Nike PG 5</div>
                            <div class="price">100.000 <sup>đ</sup></div>
                            <button class="see_product" >
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <a href="">SEE MORE</a>
                            </button>
                        </div> 
                    </div>
                    <div class="pitem">
                        <div class="imgitem">
                            <img src="../../../img/Basketball Shoes/PEAK Streetball Master.avif" alt="">
                        </div>
                        <div class="content">
                            <div class="name">PEAK Streetball Master</div>
                            <div class="price">100.000 <sup>đ</sup></div>
                            <button class="see_product" >
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                <a href="">SEE MORE</a>
                            </button>
                        </div> 
                    </div>

                </div>
                <div class="page">
                    <button class="custom-btn btn-7 prev"><span><</span></button>
                    
                    <button class="custom-btn btn-7 next"><span>></span></button>
                </div> 
            </div>  
        </div>



    </div>
    <!-- Đây là cho slider nghen -->
    <script src="../../templates/js/product_slider.js"></script>
</body>
</html>