-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table web_teo.jenis_masakan
CREATE TABLE IF NOT EXISTS `jenis_masakan` (
  `id_jenis` int NOT NULL AUTO_INCREMENT,
  `jenis` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_jenis`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table web_teo.jenis_masakan: ~5 rows (approximately)
INSERT INTO `jenis_masakan` (`id_jenis`, `jenis`) VALUES
	(2, 'Makanan Utama'),
	(3, 'Minuman'),
	(4, 'Camilan'),
	(5, 'Berkuah');

-- Dumping structure for table web_teo.kontributor
CREATE TABLE IF NOT EXISTS `kontributor` (
  `id_kontributor` int NOT NULL AUTO_INCREMENT,
  `id_resep` int NOT NULL,
  `id_jenis` int NOT NULL,
  `id_pedas` int NOT NULL,
  `id_teknik` int NOT NULL,
  PRIMARY KEY (`id_kontributor`),
  KEY `id_resep` (`id_resep`),
  KEY `id_jenis` (`id_jenis`),
  KEY `id_pedas` (`id_pedas`),
  KEY `id_teknik` (`id_teknik`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table web_teo.kontributor: ~15 rows (approximately)
INSERT INTO `kontributor` (`id_kontributor`, `id_resep`, `id_jenis`, `id_pedas`, `id_teknik`) VALUES
	(1, 1, 4, 2, 4),
	(2, 2, 5, 2, 4),
	(3, 3, 2, 4, 4),
	(4, 4, 2, 1, 4),
	(5, 5, 4, 1, 4),
	(6, 6, 2, 2, 4),
	(7, 7, 2, 3, 1),
	(8, 8, 2, 2, 2),
	(9, 9, 2, 3, 2),
	(10, 10, 2, 3, 4),
	(11, 11, 2, 4, 4),
	(12, 12, 4, 1, 3),
	(13, 13, 4, 1, 3),
	(14, 14, 4, 4, 2),
	(15, 15, 3, 1, 6),
	(16, 16, 4, 1, 6);

-- Dumping structure for table web_teo.new_user
CREATE TABLE IF NOT EXISTS `new_user` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tentang` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `gambar` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table web_teo.new_user: ~2 rows (approximately)
INSERT INTO `new_user` (`user_id`, `username`, `email`, `tentang`, `gambar`, `password`) VALUES
	(5, 'Jamilah Iplikitiw', 'jamiljamil@gmail.com', 'Aku tidak suka yang manis manis, karena aku nya udh manis akhhh', 'user/cewe 1.jpg', '123'),
	(6, 'Gwen', 'gwen@gmail.com', 'Haloo namaku gwen', 'user/ceweeeee.jpg', '123'),
	(7, 'Udin', 'udin@gmail.com', 'abcd', 'user/mas agus.jpg', '123');

-- Dumping structure for table web_teo.pedas
CREATE TABLE IF NOT EXISTS `pedas` (
  `id_pedas` int NOT NULL AUTO_INCREMENT,
  `tingkat_pedas` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_pedas`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table web_teo.pedas: ~4 rows (approximately)
INSERT INTO `pedas` (`id_pedas`, `tingkat_pedas`) VALUES
	(1, 'Tidak pedas'),
	(2, 'Sedang'),
	(3, 'Pedas'),
	(4, 'Meler');

-- Dumping structure for table web_teo.resep
CREATE TABLE IF NOT EXISTS `resep` (
  `id_resep` int NOT NULL AUTO_INCREMENT,
  `nama_resep` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `bahan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `langkah` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `gambar` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `deskripsi` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_resep`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table web_teo.resep: ~11 rows (approximately)
INSERT INTO `resep` (`id_resep`, `nama_resep`, `bahan`, `langkah`, `gambar`, `deskripsi`) VALUES
	(5, 'Pisang Goreng Krispy', '<p><strong>Bahan Utama</strong></p><p>- 2 pisang tanduk</p><p>- Minyak goreng</p><p>&nbsp;</p><p><strong>Bahan Adonan Celup</strong></p><p>- 2 pisang tanduk</p><p>- Minyak goreng</p><p>- 2 pisang tanduk</p><p>- 6 sendok makan tepung terigu</p><p>- 1 sendok makan tepung maizena</p><p>- 1 sendok teh gula pasir</p><p>- ¼ sendok teh vanili bubuk</p><p>- ¼ sendok teh garam</p><p>&nbsp;</p><p><strong>Bahan </strong><i><strong>Kremesan</strong></i></p><p>- 8-9 sendok makan tepung tapioka</p><p>- 2 sendok makan tepung beras</p><p>- 400 ml air</p><p>- 1 sendok makan gula pasir</p><p>- 1 kuning telur</p><p>- ½ sendok teh garam</p><p>- ½ sendok teh baking powder</p>', '<p>1. Siapkan pisang tanduk dengan mengupas kulitnya. Kemudian, potong-potong pisang menjadi tiga bagian. Kamu juga bisa pakai pisang jenis lain, misalnya pisang kepok. Boleh juga pisang raja, <i>pokoknya </i>pilih pisang yang punya tekstur padat.</p><p>2. Semua bahan adonan celup dicampurkan, lalu diaduk rata sampai nggak bergerindil, dan adonannya halus.</p><p>3. Siapkan wadah lain, bisa pakai mangkuk yang sudah disiapkan. Masukkan semua bahan <i>kremesan </i>ke dalam mangkuk, campurkan, aduk rata sampai nggak bergerindil.</p><p>4. Sekarang, siapkan botol kemasan air mineral yang sudah nggak terpakai. Buka tutup botol lalu lubangi tutupnya kecil-kecil, sebanyak 3-5 lubang. Tuangkan adonan kremes ke dalam botol tersebut, lalu tutup botolnya pakai penutupnya.</p><p>5. Siapkan wajan di kompor. Tuangkan minyak goreng agak banyak ke dalam wajan dan panaskan. Tunggu sampai minyak benar-benar panas.&nbsp;</p><p>6. Sekarang tuangkan adonan <i>kremes </i>dari dalam botol dengan cara menyemprotkannya perlahan ke atas minyak di wajan. Nanti, adonan <i>kremes </i>tersebut bakal tersiram dari dalam botol dan menjadi <i>kremes </i>kecil-kecil di permukaan minyak yang panas.</p><p>7. Siapkan pisang kemudian celupkan di dalam adonan celup. Lalu, pisang tersebut dimasukkan ke tengah-tengah <i>kremes </i>yang lagi digoreng di wajan. Gulung <i>kremes </i>sampai menutupi seluruh permukaan pisang goreng sebelum menjadi keras.</p><p>8. Goreng sampai matang dan berwarna kecokelatan. Angkat, kemudian tiriskan.</p><p>9. Ulangi langkah menggoreng sampai pisang dan adonan habis.</p><p>10. Pisang goreng <i>crispy</i> siap disajikan.</p>', 'gambar/pisang goreng.jpg', 'Pisang goreng yang gurih dan krispy sangat renyah di mulut'),
	(7, 'Ayam bakar Padang', '<p><strong>Bahan Utama</strong></p><p>- 1 ekor ayam, potong empat</p><p>- 4 siung bawang putih, iris tipis</p><p>- 12 butir bawang merah, iris tipis</p><p>- 2 batang sereh, ambil bagian putihnya, memarkan</p><p>- 1 sdt&nbsp;garam</p><p>- 3/4 sdt&nbsp;gula pasir</p><p>- 3/4 sdt&nbsp;merica bubuk</p><p>- 3 buah asam kandis</p><p>- 600 ml santan encer, dari sisa perasan santan kental</p><p>- 200 ml santan kental, dari 1 butir kelapa</p><p>- 2 sdm&nbsp;minyak, untuk menumis</p><p>&nbsp;</p><p><strong>Bumbu halus:</strong></p><p>- 6 buah cabai merah keriting</p><p>- 6 buah cabai merah besar</p><p>- 8 butir kemiri, sangrai</p><p>- 3 cm jahe</p><p>- 2 cm kunyit, bakar</p>', '<p>1. Lumuri ayam dengan perasan air jeruk nipis dan garam. Lalu, diamkan 15 menit.</p><p>2. Panaskan minyak dan tumis bawang putih, bawang merah, serai, dan bumbu halus sampai harum.</p><p>3. Kemudian masukkan potongan ayamnya. Aduk sampai berubah warna.</p><p>4. Masukkan santan encer, garam, gula pasir, merica bubuk, dan asam kandis. Masak sampai mendidih.</p><p>5. Kemudian tuangkan santan kental, masak sampai kental. Ayam sudah bisa dipanggang di atas bakaran atau panggangan sampai matang.</p><p>6. Sajikan ayam panggang dengan sisa bumbunya.</p>', 'gambar/ayam bakar.jpg', 'Ayam bakar yang mengingatkan akan kampung padang baik rasanya maupun aromanya'),
	(8, 'Sop Buntut', '<p>- 3 buah kepala ikan kakap segar</p><p>- 1 buah jeruk nipis, peras airnya</p><p>- 2 buah tomat merah, masing-masing belah empat</p><p>- 2 lembar daun jeruk</p><p>- 2 lembar daun salam</p><p>- 2 batang serai, memarkan</p><p>- 2 cm lengkuas, memarkan</p><p>- 2 cm jahe, memarkan</p><p>- 5 buah cabai rawit, utuhkan</p><p>- Bawang merah goreng, secukupnya</p><p>- Minyak goreng, secukupnya</p><p>&nbsp;</p><p><strong>Bumbu Halus</strong></p><p>- 3 siung bawang putih</p><p>- 2 butir kemiri</p><p>- 2 cm kunyit</p><p>- 1 sdt garam</p><p>- Sejumput gula</p><p>- 1/4 sdt kaldu penyedap bubuk</p><p>- Sejumput lada bubuk, jika suka</p>', '<p>Cuci bersih kepala ikan kakap, beri perasan air jeruk nipis dan diamkan selama beberapa waktu. Cuci kembali kepala ikan kakap sebelum dimasak.</p><p>Panaskan sedikit minyak, tumis bumbu halus hingga harum.</p><p>Tambahkan air secukupnya kemudian masukkan kepala ikan kakap ke dalam wajan, rebus bersama bumbu hingga kepala ikan matang dan empuk.</p><p>Tambahkan batang serai, daun jeruk, daun salam, lengkuas, jahe dan cabai rawit. Rebus lagi hingga bumbu meresap.</p><p>Terakhir masukkan tomat dan tambahkan penyedap masakan. Koreksi rasa, masak hingga mendidih kemudian angkat jika sudah matang.</p><p>Sajikan sup kepala ikan yang enak sebagai lauk makan siang atau sarapan.</p>', 'gambar/sop buntut.jpg', 'Nikmati kehangatan dari sop khas Indonesia yang menggoda dengan potongan buntut sapi yang lembut, direbus dalam kaldu gurih yang dipadu dengan rempah-rempah pilihan. '),
	(9, 'Rawon', '<p>- 500 gr daging sapi</p><p>&nbsp;</p><p><strong>Bumbu Utuh</strong></p><p>- 2 batang serai, memarkan</p><p>- 1 ruas lengkuas, memarkan</p><p>- 3 lembar daun salam</p><p>- 5 lembar daun jeruk</p><p>- air secukupnya</p><p>- 2 batang daun bawang, potong-potong</p><p>- gula dan garam secukupnya</p><p>&nbsp;</p><p><strong>Bumbu Halus</strong></p><p>- 3 buah kluwak, rendam dengan air hangat</p><p>- 7 siung bawang putih</p><p>- 5 siung bawang merah</p><p>- 3 butir kemiri</p><p>- 2 ruas kunyit</p><p>- 2 cm jahe</p><p>- 1 sdt merica butir</p><p>&nbsp;</p><p><strong>Bahan Pelengkap</strong></p><p>- Tauge kacang hijau</p><p>- Kerupuk udang</p><p>- Sambal bajak</p>', '<p>1. Rebus air dan masak daging sapi hingga matang dan mengeluarkan busa, buang busanya hingga airnya bersih. Masak terus hingga daging empuk. Tiriskan dan potong-potong sesuai selera.</p><p>2. Tumis bumbu halus hingga harum, masukkan semua bumbu iutuh dan tumis lagi hingga bumbu sedap dan matang.</p><p>3. Rebus lagi daging dengan air rebusan/kaldu yang tadi. Tuang bumbu rawon ke dalamnya. Aduk rata, masukkan gula dan garam secukupnya. Masak hingga kuah mengental, daging empuk dan bumbu meresap ke dalam daging.</p>', 'gambar/rawon.jpg', 'Rasakan kelezatan Indonesia dengan hidangan berkuah hitam pekat yang khas dari Jawa Timur.'),
	(10, 'Oseng Cumi Asin Pedas', '<p><span style="background-color:rgb(255,255,255);color:rgb(26,26,26);">- 500 gr cumi asin ukuran kecil.</span><br><span style="background-color:rgb(255,255,255);color:rgb(26,26,26);">-&nbsp;100 gr cabai rawit merah.</span><br><span style="background-color:rgb(255,255,255);color:rgb(26,26,26);">-&nbsp;100 gr cabai hijau keriting.</span><br><span style="background-color:rgb(255,255,255);color:rgb(26,26,26);">-&nbsp;12 siung bawang merah.</span><br><span style="background-color:rgb(255,255,255);color:rgb(26,26,26);">-&nbsp;6 siung bawang putih.</span><br><span style="background-color:rgb(255,255,255);color:rgb(26,26,26);">-&nbsp;1 bombai cincang.</span><br><span style="background-color:rgb(255,255,255);color:rgb(26,26,26);">-&nbsp;2 lembar daun salam.</span><br><span style="background-color:rgb(255,255,255);color:rgb(26,26,26);">-&nbsp;4 lembar daun jeruk.</span><br><span style="background-color:rgb(255,255,255);color:rgb(26,26,26);">-&nbsp;2 sdm saus tiram.</span><br><span style="background-color:rgb(255,255,255);color:rgb(26,26,26);">-&nbsp;1 sdm kecap manis.</span><br><span style="background-color:rgb(255,255,255);color:rgb(26,26,26);">-&nbsp;Garam, gula, dan kaldu bubuk secukupnya.</span></p>', '<p><span style="background-color:rgb(255,255,255);color:rgb(26,26,26);">1. Cucu cumi asin lalu rendam sekitar 15 menit dalam air panas dan bilas kembali cumi hingga bersih.</span><br>&nbsp;</p><p><span style="background-color:rgb(255,255,255);color:rgb(26,26,26);">2. Iris bahan-bahan dan tumis bawang merah, bawang putih, daun salam, dan daun jeruk dengan minyak panas di wajan hingga harum.</span><br>&nbsp;</p><p><span style="background-color:rgb(255,255,255);color:rgb(26,26,26);">3. Masukkan irisan rawit merah dan bombai cincang. Aduk dan masukkan cumi asin, masak dengan api kecil.</span><br>&nbsp;</p><p><span style="background-color:rgb(255,255,255);color:rgb(26,26,26);">4. Bumbui dengan saus tiram, kecap, dan garam secukupnya.</span><br>&nbsp;</p><p><span style="background-color:rgb(255,255,255);color:rgb(26,26,26);">5. Masukkan irisan cabai hijau keriting, masak hingga cabai &nbsp;layu. Tambahkan kaldu bubuk atau gula sesuai selera.</span><br>&nbsp;</p><p>6<span style="background-color:rgb(255,255,255);color:rgb(26,26,26);">. Oseng cumi asin pedas siap disajikan dan disantap dengan nasi hangat.</span></p>', 'gambar/cumi asin pedas.jpg', 'Nikmati cita rasa laut yang gurih dalam hidangan ini, dengan cumi asin yang digoreng kering dan disajikan dengan saus pedas yang meresap.'),
	(11, 'Ampela Masak Balado Khas Padang', '<p>- 1/2 kg ampela ayam</p><p>- 1 batang serai, memarkan</p><p>- 1 sdt gula pasir</p><p>- 1 sdt garam</p><p>- 1 lembar daun salam</p><p>- 3 lembar daun jeruk</p><p>- Minyak goreng dan air secukupnya</p><p>- Bumbu Halus:</p><p>- 2 buah tomat</p><p>- 12 siung bawang merah</p><p>- 10 siung bawang putih</p><p>- 12 buah cabai rawit merah</p><p>- 1/2 sdm ketumbar bubuk</p><p>- 1/4 sdt lada bubuk</p><p>- 2 butir kemiri</p><p>- 5 cm kunyit, memarkan</p>', '<p>1. Cuci ampela dan beri air perasan jeruk nipis, sisihkan.</p><p>&nbsp;</p><p>2. Lalu haluskan semua bahan bumbu menggunakan blender, tumis hingga matang.</p><p>&nbsp;</p><p>3. Tambahkan kaldu ayam, garam, dan sedikit air, aduk merata.</p><p>&nbsp;</p><p>4. Lalu masukkan ampela dan tunggu hingga air sedikit menyusut, sisihkan.</p><p>&nbsp;</p><p>5. Buat sambal balado dengan menumis bumbunya secara kasar.</p><p>&nbsp;</p><p>6. Tambahkan daun jeruk hingga berbagai bumbu perasa, koreksi rasanya.</p><p>&nbsp;</p><p>7. Masukkan ampela yang telah ditumis dan aduk hingga merata.</p><p>&nbsp;</p><p>8. Matikan api dan angkat.</p><p>&nbsp;</p><p>9. Hidangkan selagi hangat dan nikmat.</p>', 'gambar/Ampela Masak Balado Khas Padang.jpg', 'Menyajikan cita rasa pedas khas Minangkabau dengan ampela ayam yang dimasak dalam saus balado merah yang menggugah selera. '),
	(12, 'Kue Lapis Pandan', '<p>- 85 gram tepung hunkwe</p><p>&nbsp;</p><p>- 50 gram tepung terigu serba guna</p><p>&nbsp;</p><p>- 60 gram gula pasir</p><p>&nbsp;</p><p>- 400 ml santan</p><p>&nbsp;</p><p>- 1/4 sdt garam</p><p>&nbsp;</p><p>- 2 lembar daun pandan</p><p>&nbsp;</p><p>- 2 tetes pasta pandan</p>', '<p>1. Masak santan, garam, dan daun pandan hingga mendidih. Angkat, dan biarkan santan dingin.</p><p>&nbsp;</p><p>2. Masukkan daun pandan bekas rebusan santan ke air kukusan. Panaskan kukusan.</p><p>&nbsp;</p><p>3. Campur tepung hunkwe, terigu, dan gula pasir.</p><p>&nbsp;</p><p>4. Tuang santan sedikit demi sedikit ke adonan tepung dengan whisk hingga tercampur rata dan tidak bergerindil.</p><p>&nbsp;</p><p>5. Bagi adonan jadi dua. Satu bagian tetap putih, satu bagian diberi pasta pandan.</p><p>&nbsp;</p><p>6. Siapkan loyang yang sudah diolesi minyak. Tuang 100 ml adonan putih, kukus selama 7 menit.</p><p>&nbsp;</p><p>7. Tuang 100 ml adonan pandan, kukus 7 menit. Lakukan berselang-seling hingga adonan habis dengan jeda pengukusan 7 menit.</p><p>&nbsp;</p><p>8. Kukus selama 30 menit hingga matang.</p>', 'gambar/lapis pandan.jpg', 'Kelezatan tradisional ini sering disajikan sebagai camilan atau hidangan penutup istimewa dalam berbagai perayaan di Indonesia, mempesona dengan kombinasi cita rasa manis dan aroma pandan yang segar.'),
	(13, 'Kue Amparan Tatak', '<p>Bahan A:</p><p>- 30 gr&nbsp;tepung beras</p><p>- 250 ml santan kental</p><p>- 25 gr gula pasir</p><p>- 1/2 sdt garam</p><p>&nbsp;</p><p>Bahan B:</p><p>- 6 buah pisang raja, potong-potong tipis</p><p>- 100 gr tepung beras</p><p>- 300 ml santan</p><p>- 50 gr gula pasir</p><p>- 1/2 sdt vanili bubuk</p><p>- 1/4 sdt garam</p><p>- 2 lembar daun pandan</p>', '<p>1. Buat dulu lapisan bawahnya dulu dengan bahan B. Masak dulu santan hingga panas, masukkan gula, garam dan daun pandan yang sudah diremas dan ikat simpul. Aduk terus hingga larut. Angkat.</p><p>2. Campurkan tepung beras dan vanili dalam wadah tahan panas. Tuang santan sambil disaring ke dalam tepung, aduk rata hingga lembut dan halus tidak bergerindil.</p><p>3. Panaskan kukusan. Siapkan loyang, olesi dengan minyak goreng. Tuang adonan ke dalam loyang, sisakan 1/3 adonan. Tutup dan kukus selama 15 menit.</p><p>4. Campurkan 1/3 adonan dengan potongan pisang raja. Setelah pengukusan 15 menit, buka dan tuang adonan pisang. Tutup kembali dan kukus lagi selama 15 menit.</p><p>5. Selagi menunggu adonan kukus, buat lapisan atasnya dengan bahan A.</p><p>6. Campurkan semua bahan, aduk rata hingga tidak ada yang bergerindil. Saring ke dalam panci, nyalakan api. Masak hingga meletup-letup dan tidak ada yang bergerindil. Matikan api.</p><p>7. Tuang adonan ke atas lapisan pisang setelah matang, kembali kukus lagi selama 15 menit. Setelah padat matang, matikan api, keluarkan dari kukusan dan biarkan dingin.</p><p>8. Keluarkan dari cetakan dan potong-potong.</p>', 'gambar/Kue Amparan Tatak.jpg', 'Teksturnya yang lembut dan aroma kelapa yang khas membuatnya menjadi pilihan camilan yang sempurna untuk menemani sore hari atau sebagai hidangan penutup spesial dalam acara keluarga.'),
	(14, 'Seblak', '<p>- 3 genggam kerupuk (boleh direbus dulu sebentar)</p><p>- 4 buah sosis sapi, potong serong</p><p>- 2 butir telur</p><p>- 5 buah otak-otak udang, goreng lalu potong serong</p><p>- 10 buah bakso sapi kecil</p><p>- 1 genggam makaroni spiral, rendam air panas</p><p>- 1 ikat kecil sawi, potong-potong</p><p>- 1 batang daun bawang, rajang</p><p>&nbsp;</p><p>Bumbu halus:</p><p>- 4 siung bawang putih</p><p>- 6 siung bawang merah</p><p>- 3 cm kencur</p><p>- 3 buah cabai merah besar</p><p>- 15 buah cabai rawit- gula, garam, merica, kaldu bubuk secukupnya</p><p>&nbsp;</p>', '<p>1. Tumis bumbu halus hingga harum dan matang, masukkan potongan sosis dan telur, buat orak-arik.</p><p>2. Beri air secukupnya, tunggu hingga mendidih lalu masukkan krupuk, masak hingga krupuk cukup lembek.</p><p>3. Masukkan otak-otak dan bakso sapi, bumbui dengan gula, garam, merica, dan kaldu bubuk.</p><p>4. Tambahkan sawi, makaroni dan juga daun bawang, masak sebentar. Koreksi rasa, lalu angkat dan hidangkan.</p><p>&nbsp;</p>', 'gambar/seblak.jpg', 'Hidangan ini sering ditemukan di jalanan Indonesia, menawarkan pengalaman kuliner yang menggugah selera dengan kombinasi tekstur yang beragam dan cita rasa yang kaya.'),
	(15, 'Es Cendol', '<p>- 100 gr gula pasir</p><p>- 500 ml air</p><p>- 3 lembar daun pandan</p><p>- 1 bks cendol siap olah</p><p>&nbsp;</p><p><strong>Bahan saus santan:</strong></p><p>- 500 ml santan</p><p>- 300 ml air</p><p>- 1 sdt garam</p><p>- 2 lembar daun pandan</p>', '<p>1. Siapkan panci di atas kompor. Di dalam panci masukkan gula pasir, air dan daun pandan. Kemudian masak hingga mendidih. Angkat dan saring. Tunggu hingga dingin.</p><p>2. Siapkan panci yang berbeda di atas kompor. Di dalam panci masukkan santan, air, garam dan daun pandan. Masak sambil terus diaduk-aduk hingga mendidih. Angkat dan dinginkan.</p><p>3. Kemudian cuci cendol siap olah dari pasar dengan air matang.&nbsp;</p><p>4. Untuk tahap penyajian. Siapkan gelas saji. Di dalam gelas saji masukkan beberapa sendok cendol sesuai selera. Tuang saus gula merah dan santan secukupnya. Tambahkan es batu. Es cendol dawet siap disajikan.</p>', 'gambar/cendol.jpg', 'Rasanya manis gurih dengan aroma santan yang khas, membuat es cendol menjadi pilihan yang sempurna untuk menikmati kesegaran di cuaca yang panas atau sebagai hidangan penutup yang menyegarkan setelah makan.'),
	(16, 'Es Pisang Ijo', '<p><strong>Bahan:</strong></p><p>- 14 buah pisang raja kecil</p><p>&nbsp;</p><p><strong>Bahan Kulit:</strong></p><p>- 130 gr tepung beras</p><p>- 160 gr terigu</p><p>- 1 sdm tapioka</p><p>- 1 bungkus santan instan 65 ml</p><p>- 3 sdm minyak sayur atau margarin</p><p>- 550 ml air</p><p>- 50 gr gula pasir</p><p>- 1/2 sdt garam</p><p>- Pasta pandan secukupnya</p><p>&nbsp;</p><p><strong>Bahan Bubur Sum-Sum:</strong></p><p>- 130 gr tepung beras</p><p>- 1000 ml air santan</p><p>- Sekitar 1 sdt gula pasir</p><p>- Sekitar 1 sdt penuh garam</p><p>- Daun pandan</p>', '<p>1. Kukus pisang sekitar 10 menit, biarkan sebentar, lalu buka tutupnya. Tunggu hingga dingin, baru kupas kulitnya.</p><p>2. Campur tepung, gula, garam, dan aduk rata. Tambahkan air, santan, pasta pandan, dan aduk rata. Saring agar adonan halus.</p><p>3. Tambahkan minyak sayur atau margarin agar lebih enak. Lalu, aduk-aduk di atas kompor hingga adonan mengental dan kalis.</p><p>4. Biarkan hingga suhunya suam-suam kuku, lalu bagi menjadi beberapa bagian sesuai banyaknya pisang.</p><p>5. Ambil 1 bagian adonan kulit. Pipihkan dengan lambaran plastik yang sudah dioles sedikit minyak sayur.</p><p>6. Ambil pisangnya, bungkus rapat, dan rapikan. Lakukan untuk semua pisangnya.</p><p>7. Setelah itu, bungkus masing-masing pisang dengan daun pisang. Jika tidak ada, bisa juga dengan plastik anti-panas.</p><p>8. Kukus sekitar 20 menit dengan api sedang cenderung kecil.</p><p>9. Untuk bubur sumsum campur tepung, air santan, gula dan garam. Berikan daun pandan yang diikat agar wangi.</p><p>10. Aduk rata agar tidak ada gumpalan. Nyalakan kompor dengan api agak kecil.</p><p>11. Aduk-aduk hingga mengental. Kemudian, tes rasa. Biarkan beberapa saat sambil diaduk terus meski sudah mengental.</p><p>12. Angkat dan tempatkan di wadah agar tidak mudah mencair.</p><p>13. Tuang bubur sum-sum di wadah, tata pisang <i>ijo</i>, berikan es batu, lalu tuang sedikit sirup pisang ambon atau <i>cocopandan</i>.</p><p>14. Siap disajikan!</p>', 'gambar/pisang ijo.jpg', 'Pisang ini disajikan dengan siraman kuah santan gula merah yang kental dan pandan, memberikan cita rasa manis gurih yang sangat memanjakan lidah. ');

-- Dumping structure for table web_teo.teknik_masak
CREATE TABLE IF NOT EXISTS `teknik_masak` (
  `id_teknik` int NOT NULL AUTO_INCREMENT,
  `teknik` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_teknik`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table web_teo.teknik_masak: ~5 rows (approximately)
INSERT INTO `teknik_masak` (`id_teknik`, `teknik`) VALUES
	(1, 'Bakar/Panggang'),
	(2, 'Rebus'),
	(3, 'Kukus'),
	(4, 'Goreng'),
	(5, 'Ungkep'),
	(6, 'Dingin');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
