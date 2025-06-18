-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 18, 2025 at 04:35 PM
-- Server version: 9.0.1
-- PHP Version: 8.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbcms`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `created_at`) VALUES
(5, 'admin', '$2y$10$v6X7Ob/8wZvcVwZ.AINMN.XBXgBMaIMw2oDrHFKpydf1DfVON2nna', '2025-06-16 08:17:16'),
(7, 'admin2', '$2y$10$FmECDw/bEPb0yEZQaj00CO8C8JtMZtZi5SgA9GsqJNhIy1oyan.Km', '2025-06-18 18:45:42');

-- --------------------------------------------------------

--
-- Table structure for table `article`
--

CREATE TABLE `article` (
  `id` int NOT NULL,
  `date` varchar(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `content` text NOT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `status` enum('draft','published','archived') DEFAULT 'published',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `article`
--

INSERT INTO `article` (`id`, `date`, `title`, `slug`, `content`, `picture`, `status`, `created_at`, `updated_at`, `user_id`) VALUES
(1, '2025-06-15', 'Hawa Sejuk dan Spot Instagramable di Taman Selecta, Cocok Buat Healing!', 'hawa-sejuk-dan-spot-instagramable-di-taman-selecta,-cocok-buat-healing!', '<p>Malang selalu punya cara buat bikin orang jatuh cinta. Salah satu tempat wisata yang wajib masuk dalam daftar kunjungan adalah <strong>Taman Rekreasi Selecta</strong>. Terletak di kawasan Batu, tempat ini terkenal dengan udaranya yang sejuk, pemandangan indah, dan pastinya banyak spot kece buat foto-foto. Kalau kamu lagi cari tempat buat santai, refreshing, atau sekadar melepas penat dari hiruk-pikuk kota, Selecta adalah pilihan yang tepat. Yuk, kita bahas lebih dalam tentang keindahan taman ini!</p>\r\n        \r\n        <h2>Sejarah dan Daya Tarik Taman Selecta</h2>\r\n        <p>Taman Rekreasi Selecta bukan tempat wisata baru. Dibangun sejak era kolonial Belanda pada tahun 1930-an, tempat ini awalnya digunakan sebagai tempat peristirahatan bagi pejabat dan orang-orang penting saat itu. Namun, seiring berjalannya waktu, Selecta berkembang menjadi taman rekreasi yang terbuka untuk umum dan menjadi salah satu destinasi wisata favorit di Malang Raya.</p>\r\n        <p>Begitu sampai di Taman Selecta, kamu langsung disambut udara segar khas pegunungan yang bikin tubuh dan pikiran jadi rileks. Lokasinya yang berada di ketinggian sekitar 1.100 meter di atas permukaan laut membuat tempat ini punya suhu yang adem, bahkan di siang hari sekalipun. Ditambah lagi, taman bunga yang luas dengan warna-warni menawan bikin suasana makin nyaman dan menyenangkan.</p>\r\n        \r\n        <h2>Spot Instagramable yang Wajib Dikunjungi</h2>\r\n        <p>Selain keindahan alamnya, Selecta juga menawarkan banyak spot instagramable yang cocok buat mempercantik feed media sosialmu. Ada taman bunga dengan latar belakang perbukitan hijau, jembatan kecil yang dikelilingi tanaman warna-warni, hingga kolam air jernih yang bisa jadi tempat foto estetik. Salah satu spot favorit pengunjung adalah <strong>sky bike</strong>, yaitu sepeda yang melayang di atas taman, memberikan sensasi unik dan pemandangan spektakuler dari atas.</p>\r\n        \r\n        <h2>Wahana Seru di Taman Selecta</h2>\r\n        <p>Kalau datang ke sini, jangan lupa juga buat menikmati wahana seru yang ada di dalam taman. Selain sky bike, ada juga wahana perahu ayun, water park, hingga kuda tunggang buat anak-anak maupun dewasa. Kolam renang di Selecta juga cukup menarik karena airnya yang jernih dan sejuk, langsung dari sumber alami di sekitar pegunungan.</p>\r\n        \r\n        <h2>Kulineran di Taman Selecta</h2>\r\n        <p>Setelah puas jalan-jalan dan bermain, kamu bisa mampir ke restoran atau area kuliner di dalam Selecta untuk menikmati makanan khas Malang, seperti bakso Malang yang terkenal lezat. Ada juga berbagai camilan seperti jagung bakar dan pisang goreng yang pas banget disantap sambil menikmati udara dingin di sini.</p>\r\n        \r\n        <h2>Tips Berkunjung ke Taman Selecta</h2>\r\n        <ul>\r\n            <li><strong>Datang di pagi atau sore hari</strong> - Suhu lebih segar dan suasana lebih nyaman.</li>\r\n            <li><strong>Gunakan pakaian yang nyaman</strong> - Udara cukup dingin, pakailah jaket atau pakaian hangat.</li>\r\n            <li><strong>Bawa kamera atau ponsel dengan baterai penuh</strong> - Banyak spot bagus yang sayang kalau nggak diabadikan.</li>\r\n            <li><strong>Siapkan uang tunai</strong> - Beberapa tempat menerima pembayaran digital, tetapi lebih baik membawa uang tunai.</li>\r\n        </ul>\r\n        \r\n        <h2>Kesimpulan</h2>\r\n        <p>Jadi, kalau kamu butuh tempat buat <strong>healing</strong> dari kesibukan sehari-hari, Taman Selecta adalah pilihan yang sempurna. Dengan udara sejuk, pemandangan indah, dan banyak spot foto keren, tempat ini cocok banget buat liburan santai bersama keluarga, teman, atau bahkan solo trip. Yuk, rencanakan perjalananmu ke Selecta dan rasakan sendiri keindahannya!</p>', '684ee48258ef7.jpg', 'published', '2025-06-15 12:01:59', '2025-06-15 22:19:30', NULL),
(2, '2025-06-15', 'Jelajah Museum Angkut: Wisata Edukasi Seru untuk Pecinta Otomotif', 'jelajah-museum-angkut:-wisata-edukasi-seru-untuk-pecinta-otomotif', '<p>Kalau kamu pecinta kendaraan atau suka dengan sejarah transportasi, Museum Angkut di Batu, Malang, wajib masuk dalam daftar tempat wisata yang harus dikunjungi!</p>\r\n    <p>Museum ini bukan sekadar tempat pajangan mobil dan motor lawas, tapi juga mengajak pengunjung menjelajahi perkembangan dunia otomotif dari masa ke masa dengan cara yang seru dan interaktif.</p>\r\n    <p>Mulai dari kendaraan klasik, pesawat, hingga suasana kota-kota terkenal dunia, semua bisa kamu temukan di sini. Yuk, kita jelajahi Museum Angkut lebih dalam!</p>\r\n\r\n    <p><strong>Sejarah dan Konsep Museum Angkut</strong></p>\r\n    <p>Museum Angkut pertama kali dibuka pada tahun 2014 oleh Jatim Park Group, pengelola beberapa destinasi wisata populer di Batu. Sebagai museum transportasi pertama dan terbesar di Asia Tenggara, tempat ini punya koleksi lebih dari 300 kendaraan dari berbagai era dan negara.</p>\r\n    <p>Bukan hanya mobil dan motor klasik, tapi juga pesawat, sepeda, becak, hingga kendaraan khas berbagai daerah di Indonesia dan dunia.</p>\r\n\r\n    <p>Yang bikin Museum Angkut makin menarik adalah konsepnya yang tematik. Jadi, saat menjelajahi museum ini, kamu seperti berpindah dari satu kota ke kota lain dengan atmosfer yang benar-benar berbeda. Setiap zona dibuat mirip dengan aslinya, lengkap dengan bangunan, lampu, bahkan musik khas yang membuat pengalamanmu semakin seru.</p>\r\n\r\n    <h4><strong>Zona-Zona Menarik di Museum Angkut</strong></h4>\r\n\r\n    <p><strong>1. Zona Hall Utama</strong></p>\r\n    <p>Begitu masuk, kamu langsung disambut dengan berbagai koleksi kendaraan antik yang elegan. Di sini, ada mobil-mobil klasik dari Amerika dan Eropa yang dulu digunakan oleh para pejabat dan orang-orang berpengaruh di dunia. Salah satu yang paling menarik perhatian adalah mobil kepresidenan yang pernah digunakan oleh Presiden Soekarno!</p>\r\n\r\n    <p><strong>2. Zona Edukasi</strong></p>\r\n    <p>Buat kamu yang penasaran dengan sejarah perkembangan transportasi dari zaman ke zaman, zona ini cocok banget untuk dikunjungi. Ada berbagai informasi menarik tentang bagaimana kendaraan berkembang, mulai dari kereta kuda, sepeda, hingga mobil listrik masa kini.</p>\r\n\r\n    <p><strong>3. Zona Sunda Kelapa &amp; Batavia</strong></p>\r\n    <p>Zona ini menggambarkan suasana pelabuhan Sunda Kelapa pada masa kolonial Belanda. Kamu bisa melihat replika kapal besar, becak tempo dulu, dan berbagai kendaraan khas dari era tersebut. Ditambah dengan suasana khas pasar dan pelabuhan zaman dulu, tempat ini cocok buat yang suka berfoto dengan nuansa vintage.</p>\r\n\r\n    <p><strong>4. Zona Amerika</strong></p>\r\n    <p>Kalau kamu penggemar mobil klasik ala Hollywood, zona ini pasti jadi favoritmu! Ada banyak kendaraan khas Amerika seperti Cadillac, Chevrolet, hingga Ford Mustang. Zona ini juga dihiasi dengan suasana kota-kota di Amerika, lengkap dengan replika Hollywood dan Broadway yang ikonik.</p>\r\n\r\n    <p><strong>5. Zona Eropa</strong></p>\r\n    <p>Di sini, kamu bakal merasa seperti sedang berjalan di jalanan kota-kota klasik di Eropa. Mulai dari London dengan bus merah tingkatnya yang khas, Paris dengan suasana romantisnya, hingga Italia yang penuh dengan mobil-mobil sport mewah seperti Ferrari dan Lamborghini.</p>\r\n\r\n    <p><strong>6. Zona Gangster &amp; Broadway</strong></p>\r\n    <p>Buat kamu yang suka suasana film mafia ala Amerika, zona ini menawarkan pengalaman unik. Dengan latar belakang kota gangster tahun 1920-an, lengkap dengan kendaraan klasik dan suasana gelap penuh lampu neon, tempat ini sering jadi spot favorit untuk foto-foto keren.</p>\r\n\r\n    <h4><strong>Wahana dan Atraksi Menarik</strong></h4>\r\n    <p>Selain koleksi kendaraan yang super keren, Museum Angkut juga menawarkan berbagai atraksi yang sayang untuk dilewatkan:</p>\r\n    <ul>\r\n        <li><strong>The Presidential Car</strong> - Koleksi mobil kepresidenan, termasuk replika mobil yang pernah digunakan oleh Presiden Soekarno.</li>\r\n        <li><strong>Zona Flight Simulator</strong> - Kamu bisa merasakan sensasi menerbangkan pesawat dalam simulator yang seru dan realistis.</li>\r\n        <li><strong>Atraksi Parade Kendaraan</strong> - Setiap sore, ada parade kendaraan klasik yang dikendarai oleh staf museum dengan kostum khas sesuai dengan era kendaraannya.</li>\r\n    </ul>\r\n\r\n    <h4><strong>Zona Pasar Apung: Tempat Makan &amp; Belanja Unik</strong></h4>\r\n    <p>Setelah puas menjelajahi berbagai zona di Museum Angkut, jangan lupa mampir ke Pasar Apung Nusantara yang ada di area luar museum. Konsepnya mirip dengan pasar terapung di Kalimantan, di mana berbagai jajanan tradisional dijual dari perahu-perahu kecil.</p>\r\n    <p>Di sini, kamu bisa mencicipi makanan khas Jawa Timur seperti nasi pecel, tahu petis, rujak cingur, hingga es dawet. Selain makanan, Pasar Apung juga menjual berbagai suvenir khas Malang yang cocok buat oleh-oleh.</p>\r\n\r\n    <h4><strong>Tips Berkunjung ke Museum Angkut</strong></h4>\r\n    <ul>\r\n        <li><strong>Datang lebih awal</strong> - Museum ini cukup luas, jadi kalau ingin menjelajahi semua zona dengan puas, sebaiknya datang pagi atau siang hari.</li>\r\n        <li><strong>Gunakan pakaian dan sepatu yang nyaman</strong> - Karena kamu akan banyak berjalan, pakailah pakaian yang santai dan sepatu yang nyaman.</li>\r\n        <li><strong>Bawa kamera atau ponsel dengan baterai penuh</strong> - Ada banyak spot keren yang sayang banget kalau tidak diabadikan.</li>\r\n        <li><strong>Jangan lupa cek jadwal pertunjukan</strong> - Supaya tidak ketinggalan parade kendaraan atau atraksi seru lainnya.</li>\r\n    </ul>\r\n\r\n    <h4><strong>Kesimpulan</strong></h4>\r\n    <p>Museum Angkut bukan sekadar museum biasa, tapi tempat wisata edukasi yang menyenangkan untuk semua usia. Dengan koleksi kendaraan klasik, zona tematik yang keren, dan berbagai wahana interaktif, tempat ini cocok banget buat pecinta otomotif maupun yang sekadar ingin jalan-jalan dan hunting foto keren.</p>\r\n    <p>Jadi, kalau kamu ke Malang atau Batu, jangan lupa mampir ke Museum Angkut. Siapkan kamera, ajak teman atau keluarga, dan nikmati pengalaman menjelajahi dunia otomotif dalam suasana yang unik dan mengesankan!</p>', '684ee4910ca80.jpg', 'published', '2025-06-15 12:01:59', '2025-06-15 22:19:45', NULL),
(24, '2025-06-18', 'Keajaiban Alam yang Terabaikan: Mengapa Kita Harus Lebih Peduli', 'keajaiban-alam-yang-terabaikan:-mengapa-kita-harus-lebih-peduli', 'Alam memberikan segalanya: udara untuk bernapas, air untuk diminum, serta keindahan untuk dinikmati. Namun, dalam kesibukan manusia membangun kota dan teknologi, keajaiban alam mulai terpinggirkan. Hutan yang dulu lebat kini menjadi lahan industri. Sungai yang jernih kini tercemar oleh limbah. Semua itu terjadi perlahan, nyaris tanpa kita sadari.<div><br></div><div>Padahal, alam adalah sistem yang saling bergantung. Ketika satu bagian rusak—misalnya, pohon-pohon ditebang tanpa henti—efeknya merembet ke hewan, iklim, dan akhirnya kehidupan manusia itu sendiri. Kita tidak bisa hidup tanpa alam, tetapi alam bisa bertahan tanpa kita.</div><div><br></div><div>Kini saatnya berubah. Tidak harus menunggu menjadi aktivis untuk peduli. Mulai dari hal kecil: kurangi penggunaan plastik, tanam pohon, atau cukup jaga kebersihan saat berwisata alam. Setiap langkah kecil adalah bagian dari solusi besar.</div><div><br></div><div>Mencintai alam bukan soal tren, tapi tanggung jawab. Karena bumi bukan warisan nenek moyang, tapi titipan untuk anak cucu.</div>', '6852c93a91cfa.jpg', 'published', '2025-06-18 21:12:10', '2025-06-18 21:12:10', NULL),
(25, '2025-06-19', 'Bangun Pagi Tanpa Drama: 5 Trik Jitu agar Gak Snooze Terus', 'bangun-pagi-tanpa-drama:-5-trik-jitu-agar-gak-snooze-terus', 'Pagi hari adalah penentu suasana seharian. Tapi banyak dari kita terjebak dengan tombol snooze yang menggoda. Padahal, bangun pagi memberi banyak manfaat: mood yang stabil, fokus lebih baik, dan kesempatan produktif lebih lama. Triknya? Simpan alarm jauh dari tempat tidur, tidur di waktu yang sama setiap malam, pakai alarm yang tenang tapi konsisten, atur pencahayaan alami, dan hindari layar biru sebelum tidur. Dengan rutinitas sederhana, kamu bisa ubah pagi jadi momen favorit.', '6852def4a1c0d.jpg', 'published', '2025-06-18 22:42:26', '2025-06-18 22:44:52', NULL),
(26, '2025-06-14', 'Makanan Tinggi Serat yang Enak dan Gak Ngebosenin', 'makanan-tinggi-serat-yang-enak-dan-gak-ngebosenin', 'Serat penting untuk pencernaan, tapi kadang makanan sehat terasa membosankan. Padahal, banyak pilihan lezat: smoothie bowl dengan chia seed dan buah-buahan, overnight oats, salad quinoa, popcorn tanpa mentega, atau nasi merah dengan tumisan sayur pedas. Semua ini bisa dikreasikan sesuai selera. Kuncinya, gabungkan serat dengan rasa favoritmu agar konsisten dan nggak terasa seperti “diet”.', '6852df84a71b3.jpg', 'published', '2025-06-18 22:47:16', '2025-06-18 22:47:16', NULL),
(27, '2025-06-05', 'Destinasi “Hidden Gem” di Indonesia yang Cocok untuk Solo Trip', 'destinasi-“hidden-gem”-di-indonesia-yang-cocok-untuk-solo-trip', 'Solo traveling bukan hanya jalan-jalan, tapi proses mengenal diri. Beberapa tempat yang cocok antara lain: Sumba (Nusa Tenggara Timur) dengan savana dan pantai sunyinya, Loksado (Kalsel) untuk pengalaman menyatu dengan alam, Pulau Weh (Aceh) bagi pencinta diving, dan Ambarawa (Jateng) untuk wisata sejarah. Jalan sendiri mengajarkan kita berani, mandiri, dan lebih peka terhadap sekitar.', '6852e01002650.jpg', 'published', '2025-06-18 22:49:36', '2025-06-18 22:49:36', NULL),
(28, '2025-06-18', 'Minimalist Living: Cara Sederhana, Hidup Lebih Bahagia', 'minimalist-living:-cara-sederhana,-hidup-lebih-bahagia', 'Minimalisme bukan tentang rumah putih dan kosong, tapi hidup dengan hal yang penting. Cobalah sortir barang yang jarang dipakai, kurangi belanja impulsif, dan mulai dari satu ruangan. Dengan ruang yang lega dan barang yang esensial, hidup terasa lebih ringan. Prinsip ini juga bisa diterapkan dalam digital life: kurangi notifikasi, batasi media sosial, dan beri waktu untuk diri sendiri.', '6852e047a73f2.jpg', 'published', '2025-06-18 22:50:31', '2025-06-18 22:50:31', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `article_author`
--

CREATE TABLE `article_author` (
  `article_id` int NOT NULL,
  `author_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `article_author`
--

INSERT INTO `article_author` (`article_id`, `author_id`) VALUES
(27, 1),
(28, 1),
(2, 3),
(24, 7),
(25, 7),
(26, 7);

-- --------------------------------------------------------

--
-- Table structure for table `article_category`
--

CREATE TABLE `article_category` (
  `article_id` int NOT NULL,
  `category_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `article_category`
--

INSERT INTO `article_category` (`article_id`, `category_id`) VALUES
(24, 4),
(1, 5),
(2, 5),
(25, 8),
(25, 9),
(26, 9),
(26, 10),
(27, 12),
(27, 13),
(28, 14),
(28, 15);

-- --------------------------------------------------------

--
-- Table structure for table `author`
--

CREATE TABLE `author` (
  `id` int NOT NULL,
  `nickname` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `author`
--

INSERT INTO `author` (`id`, `nickname`, `email`, `password`) VALUES
(1, 'Budi', 'budi@example.com', '$2y$10$NnHj/Sa3IbZO85XtMFY4KO48osqPM9IRiu3UeU7DRzJ..rE89jpT2'),
(2, 'Didik', 'didik@example.com', 'password123'),
(3, 'Iwan', 'iwan@example.com', 'password123'),
(7, 'alya', 'alya123@gmail.com', '$2y$10$p4fCNNkQHP9c72MfExreeONxuHnXew3CrrIKP9nCG1f82DFzogeNS');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `description`) VALUES
(4, 'Alam', 'Kategori yang mencakup tempat wisata alam seperti gunung, pantai, air terjun, dan hutan wisata.'),
(5, 'Pendidikan', 'Kategori yang berisi tempat wisata edukasi seperti museum, pusat sains, kebun binatang, dan planetarium.'),
(6, 'Taman', 'Kategori yang mencakup tempat wisata taman rekreasi seperti taman kota, taman hiburan, dan taman bermain.'),
(8, 'Life Hacks', 'Tips praktis untuk membuat hidup sehari-hari lebih mudah, efisien, dan menyenangkan. Mulai dari rutinitas pagi, cara mengatur waktu, hingga trik hemat yang bisa langsung diterapkan.'),
(9, 'Kesehatan', 'Topik yang berkaitan dengan gaya hidup sehat secara fisik, seperti pola makan, olahraga, manfaat aktivitas ringan, dan kebiasaan sehari-hari yang menyehatkan tubuh.'),
(10, 'Kuliner', 'Segala hal tentang makanan dan minuman, termasuk resep sehat, ide makan praktis, hingga makanan khas daerah yang menggugah selera.\r\n\r\n'),
(11, 'Mental health', 'Topik tentang pengelolaan stres, emosi, mindfulness, dan aktivitas sederhana untuk menjaga kesejahteraan pikiran dan perasaan.\r\n\r\n'),
(12, 'Travel', 'Informasi dan inspirasi seputar perjalanan, destinasi menarik, tips solo traveling, hidden gem di Indonesia, serta cara melakukan perjalanan yang bermakna dan hemat.'),
(13, 'Self-Development / Self-Improvement', 'Kategori yang berfokus pada pertumbuhan pribadi: bagaimana menjadi versi diri yang lebih baik lewat kebiasaan baru, eksplorasi diri, hingga pengembangan mindset.\r\n\r\n'),
(14, 'Lifestyle', 'Berisi artikel tentang cara hidup yang lebih seimbang, bermakna, dan sesuai nilai pribadi, termasuk tren seperti minimalisme, slow living, dan conscious living.'),
(15, 'Home & Living', 'Segala hal tentang rumah dan ruang hidup: menata rumah, menciptakan suasana nyaman, hingga memaksimalkan ruang kecil agar terasa lega dan fungsional.\r\n\r\n'),
(16, 'Karier', 'Berfokus pada produktivitas kerja, etika profesional, manajemen waktu, hingga tips sukses bekerja secara remote atau dalam tim.'),
(17, 'Teknologi', 'Informasi seputar aplikasi, perangkat digital, tren kerja modern, hingga cara menggunakan teknologi untuk menunjang produktivitas dan keseimbangan hidup.\r\n\r\n'),
(18, 'Fashion', 'Tren berpakaian, gaya berpakaian sehari-hari, hingga perpaduan budaya dalam fashion lokal dan modern. Cocok bagi yang ingin tampil stylish sekaligus berbudaya.\r\n\r\n'),
(19, 'Budaya', 'Membahas warisan tradisi, nilai-nilai lokal, dan bagaimana budaya bisa diintegrasikan dalam kehidupan modern, terutama melalui media seperti fashion dan karya kreatif.\r\n\r\n'),
(20, 'Keuangan', 'Tips mengatur keuangan pribadi secara bijak, mulai dari cara belanja hemat, mengelola pengeluaran kecil, hingga kebiasaan finansial sehat.'),
(21, 'Literasi', 'Topik yang mendorong kebiasaan membaca dan menulis. Cocok untuk pembaca yang ingin meningkatkan wawasan lewat buku, artikel, dan konten edukatif.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `title` (`title`),
  ADD KEY `fk_article_user` (`user_id`);

--
-- Indexes for table `article_author`
--
ALTER TABLE `article_author`
  ADD PRIMARY KEY (`article_id`,`author_id`),
  ADD KEY `author_id` (`author_id`);

--
-- Indexes for table `article_category`
--
ALTER TABLE `article_category`
  ADD PRIMARY KEY (`article_id`,`category_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `article`
--
ALTER TABLE `article`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `author`
--
ALTER TABLE `author`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `fk_article_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `article_author`
--
ALTER TABLE `article_author`
  ADD CONSTRAINT `article_author_ibfk_1` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `article_author_ibfk_2` FOREIGN KEY (`author_id`) REFERENCES `author` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `article_category`
--
ALTER TABLE `article_category`
  ADD CONSTRAINT `article_category_ibfk_1` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `article_category_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
