<?php
require_once 'db.php';

// 1. Check and Update Schema (Add 'district' columns if not exist)
try {
    $check = $pdo->query("SHOW COLUMNS FROM posts LIKE 'district'");
    if ($check->rowCount() == 0) {
        $pdo->exec("ALTER TABLE posts ADD COLUMN district VARCHAR(100) DEFAULT NULL AFTER category");
        $pdo->exec("ALTER TABLE posts ADD COLUMN district_en VARCHAR(100) DEFAULT NULL AFTER district");
        echo "Added 'district' columns to table.<br>";
    }
} catch (Exception $e) {
    echo "Schema check error: " . $e->getMessage() . "<br>";
}

// 2. Reset Tables (Optional - Comment out if you want to keep existing data)
$pdo->exec("TRUNCATE TABLE posts"); 
echo "Tables cleared.<br>";

// 3. Prepare Data
$contents = [
    [
        'title' => 'ประวัติศูนย์การเรียนรู้วัฒนธรรมจังหวัดเพชรบุรี',
        'title_en' => 'History of Phetchaburi Cultural Learning Center',
        'category' => 'history',
        'district' => 'Mueang',
        'district_en' => 'Mueang',
        'content' => '<b>ประวัติความเป็นมา</b><br>
จังหวัดเพชรบุรี เป็นจังหวัดที่มีทรัพยากรที่เป็นมรดกทางศิลปวัฒนธรรมของท้องถิ่นเป็นจำนวนมาก และมีความหลากหลายในเรื่องของวิถีชีวิต เนื่องจากมีองค์ประกอบในการดำเนินชีวิตของประชาชน ที่มีความโดดเด่น และเป็นเอกลักษณ์ของจังหวัดหลายด้าน อาทิ ประวัติศาสตร์ ศิลปวัฒนธรรม  งานสกุลช่างเมืองเพชร  ซึ่งเป็นภูมิปัญญาของชาวเพชรบุรี เปี่ยมด้วยองค์ความรู้ที่เป็นต้นทุนทางวัฒนธรรม  ที่ได้รับการถ่ายทอดและสืบสานงานช่างทุกสาขา  ตั้งแต่อดีตมาสู่ยุคปัจจุบัน และมีการพัฒนาสร้างสรรค์ผลงานมาอย่างต่อเนื่อง  ด้วยคุณค่าและมีลักษณะเฉพาะตัวที่โดดเด่น ซึ่งเป็นที่ประจักษ์แก่ผู้ศึกษาค้นคว้า รวมถึงผู้ชื่นชอบงานศิลป์และชื่นชมผลงาน   ทั้งในและนอกพื้นที่จังหวัดเพชรบุรี<br><br>
จังหวัด โดยสำนักงานวัฒนธรรมจังหวัดเพชรบุรี ได้รวบรวมองค์ความรู้ภูมิปัญญาในหลากหลายสาขา   ทั้งศิลปกรรมงานสกุลช่างเมืองเพชร  ประติมากรรม สถาปัตยกรรม จิตรกรรม วรรณกรรม นาฏศิลป์ และการแสดง  ตลอดจนวิถีชีวิต ขนบธรรมเนียม จารีตประเพณีและจริยธรรมอันดีงาม  โดยเริ่มจากพลังแห่งน้ำใจและความร่วมมือของผู้เกี่ยวข้อง นักวิชาการ คณาจารย์ ผู้ทรงคุณวุฒิ ช่าง ศิลปินของเมืองเพชร มาตั้งแต่วันที่ ๑๕ พฤศจิกายน ๒๕๔๘  เป็นต้นมา จัดตั้งเป็นศูนย์แสดงและสาธิตงานสกุลช่างในพื้นที่ ชั้น ๓ อาคารสำนักงานวัฒนธรรมจังหวัดเพชรบุรี เพื่อเป็นการยกย่อง เชิดชูเกียรติ ดำรงรักษา สืบทอด สร้างค่านิยม ปลุกจิตสำนึก สร้างคุณค่าทางสังคมและเศรษฐกิจ  และเปิดให้บริการอย่างเป็นทางการเมื่อวันที่ ๓  พฤษภาคม ๒๕๕๐  ต่อมาด้วยความที่จังหวัดเพชรบุรีเป็นจังหวัดที่มีความหลากหลายในเรื่องของวิถีชีวิต เนื่องจากมีองค์ในการดำเนินชีวิตของประชาชนที่ความเป็นโดดเด่นและเป็นเอกลักษณ์ของจังหวัดหลายด้าน จึงได้พัฒนาเป็นศูนย์การเรียนรู้วัฒนธรรมจังหวัดเพชรบุรี<br><br>
<b>วัตถุประสงค์</b><br>
๑. เพื่อเป็นศูนย์กลางในการบริหารจัดการองค์ความรู้ด้านศาสนา ศิลปะ และวัฒนธรรม<br>
๒. เป็นอนุรักษ์ส่งเสริมและสืบทอดมรดกทางศิลปะและวัฒนธรรมของจังหวัดเพชรบุรี<br>
๓. เพื่อเป็นแหล่งรวมองค์ความรู้ และต้นทุนทางวัฒนธรรมที่มีอยู่ นำสู่การเป็นแหล่งศึกษาค้นคว้าและพัฒนา<br>
๔. เพื่อสร้างค่านิยม จิตสำนึก ภูมิปัญญาไทย และยกย่องเชิดชูเกียรติภูมิปัญญาท้องถิ่น',
        'content_en' => '<b>History</b><br>
Phetchaburi is a province rich in local cultural heritage and diverse ways of life...<br><br>
The Phetchaburi Cultural Office established the "Phetchaburi Cultural Learning Center" on the 3rd floor of the Phetchaburi Cultural Office building to honor, preserve, and pass on these valuable cultural assets.<br><br>
<b>Objectives</b><br>
1. To serve as a central hub for managing knowledge in religion, art, and culture.<br>
2. To conserve, promote, and inherit Phetchaburi\'s art and cultural heritage.<br>
3. To be a resource center for cultural knowledge and development.<br>
4. To build values, consciousness, and honor local wisdom.',
        'image' => 'https://lh3.googleusercontent.com/p/AF1QipPflg5Z4sF8r0aQy5t2p5l-4q6q3s7v4x5y6z8=s1600-w400', 
        'video' => ''
    ],
    [
        'title' => '๑. ศูนย์แสดงและสาธิตงานสกุลช่างเมืองเพชร',
        'title_en' => '1. Phetchaburi School of Artisans Demonstration Center',
        'category' => 'learning',
        'district' => 'Mueang',
        'district_en' => 'Mueang',
        'content' => 'ศูนย์การเรียนรู้ที่จัดแสดงและสาธิตงานหัตถศิลป์และภูมิปัญญาท้องถิ่นอันเป็นเอกลักษณ์ของจังหวัดเพชรบุรี หรือที่เรียกว่า "สกุลช่างเมืองเพชร" ประกอบด้วยงานช่างหลายแขนง เช่น งานปูนปั้น งานลายรดน้ำ งานลงรักปิดทอง งานแทงหยวก และงานตอกกระดาษ เป็นต้น',
        'content_en' => 'A learning center displaying and demonstrating unique local craftsmanship and wisdom of Phetchaburi, known as the "Phetchaburi School of Artisans". It features various crafts such as stucco molding, gilded lacquer, banana stalk carving, and paper punching.',
        'image' => 'https://lh3.googleusercontent.com/p/AF1QipPflg5Z4sF8r0aQy5t2p5l-4q6q3s7v4x5y6z8=s1600-w400',
        'video' => ''
    ],
    [
        'title' => 'อัตลักษณ์จังหวัดเพชรบุรี',
        'title_en' => 'Identity of Phetchaburi',
        'category' => 'identity',
        'district' => 'Mueang',
        'district_en' => 'Mueang',
        'content' => '<b>เมือง 3 รส</b><br>
เพชรบุรีได้ชื่อว่าเป็น "เมือง 3 รส" ที่สะท้อนถึงความอุดมสมบูรณ์ของวัตถุดิบทางธรรมชาติ ได้แก่ รสเค็มจากนาเกลือบ้านแหลม รสเปรี้ยวจากมะนาวท่ายาง และรสหวานจากน้ำตาลโตนดเมืองเพชร<br><br>
<b>เมืองสกุลช่าง</b><br>
โดดเด่นด้วยงานศิลปะชั้นครู "สกุลช่างเมืองเพชร" ที่สืบทอดกันมายาวนาน ทั้งงานปูนปั้น งานแกะสลัก และงานจิตรกรรมฝาผนังที่ประดับอยู่ตามวัดวาอารามต่าง ๆ<br><br>
<b>เมืองสามวัง</b><br>
เป็นจังหวัดเดียวในประเทศไทยที่มีพระราชวังสำคัญถึง 3 แห่ง ได้แก่ พระนครคีรี (เขาวัง), พระรามราชนิเวศน์ (วังบ้านปืน) และพระราชนิเวศน์มฤคทายวัน สะท้อนถึงความสำคัญทางประวัติศาสตร์และความผูกพันกับสถาบันพระมหากษัตริย์',
        'content_en' => '<b>The City of Three Flavors</b><br>
Phetchaburi is known as the "City of Three Flavors," reflecting its rich natural resources: Salty from Ban Laem salt fields, Sour from Tha Yang limes, and Sweet from Phetchaburi toddy palm sugar.<br><br>
<b>The City of Artisans</b><br>
Distinguished by the "Phetchaburi School of Artisans," a legacy of master craftsmanship seen in stucco molding, wood carving, and murals adorning local temples.<br><br>
<b>The City of Three Palaces</b><br>
It is the only province in Thailand home to three significant royal palaces: Phra Nakhon Khiri (Khao Wang), Phra Ram Ratchaniwet (Ban Puen Palace), and Mrigadayavan Palace, reflecting its historical significance and royal heritage.',
        'image' => 'https://thailandtourismdirectory.go.th/assets/upload/2017/11/04/2017110433722a468d60107e3241437152018899144810.jpg',
        'video' => ''
    ],
    [
        'title' => '๒. ส่วนแสดงวิถีชีวิตคนเมืองเพชร',
        'title_en' => '2. Phetchaburi Way of Life Exhibition',
        'category' => 'learning',
        'district' => 'Mueang',
        'district_en' => 'Mueang',
        'content' => 'จัดแสดงเรื่องราววิถีชีวิต ความเป็นอยู่ ขนบธรรมเนียม และประเพณีของชาวเพชรบุรีในอดีต สะท้อนให้เห็นถึงความผูกพันกับสายน้ำ การทำมาหากิน และวัฒนธรรมการกินอยู่ที่เรียบง่ายแต่แฝงด้วยภูมิปัญญา',
        'content_en' => 'Exhibits the lifestyle, traditions, and customs of Phetchaburi people in the past, reflecting their bond with the river, livelihoods, and simple yet wise food culture.',
        'image' => 'https://thailandtourismdirectory.go.th/assets/upload/2021/01/27/20210127d1433f07759604118029582885934442111558.jpg',
        'video' => ''
    ],
    [
        'title' => '๓. ส่วนแสดงศิลปวัฒนธรรมร่วมสมัย',
        'title_en' => '3. Contemporary Art and Culture Exhibition',
        'category' => 'learning',
        'district' => 'Mueang',
        'district_en' => 'Mueang',
        'content' => 'พื้นที่จัดแสดงผลงานศิลปะร่วมสมัยที่สร้างสรรค์โดยศิลปินรุ่นใหม่และศิลปินในท้องถิ่น เพื่อสืบสานและต่อยอดทางวัฒนธรรมให้เข้ากับยุคสมัย',
        'content_en' => 'A space showcasing contemporary art created by new and local artists to preserve and extend cultural heritage into the modern era.',
        'image' => 'https://plus.thairath.co.th/media/dCmcxW12F7oH22502.jpg',
        'video' => ''
    ],
    [
        'title' => '๔. หอวรรณกรรมและจดหมายเหตุเมืองเพชร',
        'title_en' => '4. Phetchaburi Literature and Archives Hall',
        'category' => 'learning',
        'district' => 'Mueang',
        'district_en' => 'Mueang',
        'content' => 'รวบรวมวรรณกรรมสำคัญ เอกสารทางประวัติศาสตร์ และจดหมายเหตุที่เกี่ยวข้องกับเมืองเพชรบุรี เพื่อให้คนรุ่นหลังได้ศึกษาค้นคว้าเรื่องราวความเป็นมาของจังหวัด',
        'content_en' => 'Collects important literature, historical documents, and archives related to Phetchaburi for future generations to study the province\'s history.',
        'image' => 'https://mpics.mgronline.com/pics/Images/562000008581001.JPEG',
        'video' => ''
    ],
    [
        'title' => '๕. ส่วนแสดงและเชิดชูเกียรติศิลปินเมืองเพชร',
        'title_en' => '5. Phetchaburi Artists Hall of Fame',
        'category' => 'learning',
        'district' => 'Mueang',
        'district_en' => 'Mueang',
        'content' => 'ยกย่องเชิดชูเกียรติศิลปิน ปราชญ์ชาวบ้าน และผู้มีผลงานดีเด่นทางด้านศิลปวัฒนธรรมของจังหวัดเพชรบุรี เพื่อเป็นแบบอย่างและสร้างแรงบันดาลใจ',
        'content_en' => 'Honors artists, local scholars, and individuals with outstanding achievements in Phetchaburi\'s arts and culture to serve as role models and inspiration.',
        'image' => 'https://www.finearts.go.th/storage/contents/2020/08/948/1739/1739_1.jpg',
        'video' => ''
    ],
    [
        'title' => '๖. ส่วนแสดงนิทรรศการหมุนเวียน',
        'title_en' => '6. Rotating Exhibition Zone',
        'category' => 'learning',
        'district' => 'Mueang',
        'district_en' => 'Mueang',
        'content' => 'พื้นที่สำหรับจัดนิทรรศการพิเศษที่หมุนเวียนเปลี่ยนไปตามวาระและโอกาสต่างๆ เพื่อให้มีความหลากหลายและน่าสนใจอยู่เสมอ',
        'content_en' => 'A space for special exhibitions that change periodically according to occasions, ensuring variety and constant interest.',
        'image' => 'https://www.matichon.co.th/wp-content/uploads/2019/02/05-4.jpg',
        'video' => ''
    ],
    [
        'title' => '๗. ศูนย์การถ่ายทอดองค์ความรู้ทางวัฒนธรรม',
        'title_en' => '7. Cultural Knowledge Transfer Center',
        'category' => 'learning',
        'district' => 'Mueang',
        'district_en' => 'Mueang',
        'content' => 'สถานที่สำหรับจัดการอบรม เสวนา และถ่ายทอดความรู้ภูมิปัญญาท้องถิ่นจากปราชญ์ชาวบ้านสู่เยาวชนและผู้สนใจ',
        'content_en' => 'A venue for training, seminars, and transferring local wisdom from scholars to youth and interested individuals.',
        'image' => 'https://www.m-culture.go.th/phetchaburi/images/article/news564/n20210323142751_3321.jpg',
        'video' => ''
    ],
    [
        'title' => '๘. ศูนย์ข้อมูลกลางทางวัฒนธรรม',
        'title_en' => '8. Central Cultural Information Center',
        'category' => 'learning',
        'district' => 'Mueang',
        'district_en' => 'Mueang',
        'content' => 'แหล่งรวบรวมและให้บริการข้อมูลสารสนเทศด้านวัฒนธรรมของจังหวัดเพชรบุรี ผ่านระบบฐานข้อมูลที่ทันสมัยและเข้าถึงได้ง่าย',
        'content_en' => 'A center collecting and providing cultural information of Phetchaburi through a modern and accessible database system.',
        'image' => 'https://www.m-culture.go.th/phetchaburi/images/article/news564/n20210323142751_3321.jpg',
        'video' => ''
    ],
    [
        'title' => 'ตาลโตนดเมืองเพชร',
        'title_en' => 'Phetchaburi Toddy Palm',
        'category' => 'learning',
        'district' => 'Mueang',
        'district_en' => 'Mueang',
        'content' => 'เพชรบุรีขึ้นชื่อเรื่องตาลโตนด ซึ่งเป็นพืชเศรษฐกิจที่นำมาทำขนมหวานและน้ำตาลสดที่มีชื่อเสียง',
        'content_en' => 'Phetchaburi is famous for Toddy Palms, an economic crop used to make the province\'s renowned desserts and fresh sugar.',
        'image' => 'https://thailandtourismdirectory.go.th/assets/upload/2017/11/20/2017112028670150965e63820252516644026369094326.jpg',
        'video' => ''
    ],

    // --- User Provided 72 Attractions ---

    // 1. Mueang Phetchaburi
    [
        'title' => 'พิพิธภัณฑสถานแห่งชาติพระนครคีรี และอุทยานประวัติศาสตร์พระนครคีรี (เขาวัง)',
        'title_en' => 'Phra Nakhon Khiri National Museum (Khao Wang)',
        'category' => 'attraction',
        'district' => 'Mueang',
        'district_en' => 'Mueang',
        'content' => 'โบราณสถานเก่าแก่คู่เมืองเพชรบุรี ตั้งอยู่บนยอดเขา 3 ยอด เป็นที่ประทับแปรพระราชฐานของรัชกาลที่ 4',
        'content_en' => 'An ancient historical site of Phetchaburi located on three hill peaks, served as the royal summer residence of King Rama IV.',
        'image' => 'https://thai.tourismthailand.org/images/attraction/Attraction394-01.jpg',
        'video' => ''
    ],
    [
        'title' => 'พระรามราชนิเวศน์ (วังบ้านปืน)',
        'title_en' => 'Phra Ram Ratchaniwet (Ban Puen Palace)',
        'category' => 'attraction',
        'district' => 'Mueang',
        'district_en' => 'Mueang',
        'content' => 'พระราชวังสไตล์บาโรกและอาร์ตนูโว สร้างในสมัยรัชกาลที่ 5',
        'content_en' => 'A Baroque and Art Nouveau style palace built during the reign of King Rama V.',
        'image' => 'https://thai.tourismthailand.org/images/attraction/Attraction395-01.jpg',
        'video' => ''
    ],
    [
        'title' => 'ถ้ำเขาหลวง',
        'title_en' => 'Khao Luang Cave',
        'category' => 'attraction',
        'district' => 'Mueang',
        'district_en' => 'Mueang',
        'content' => 'ถ้ำสวยงามที่มีปล่องแสงส่องลงมากระทบพระพุทธรูปฉลองพระองค์',
        'content_en' => 'A beautiful cave with a skylight illuminating the Buddha image.',
        'image' => 'https://thai.tourismthailand.org/images/attraction/Attraction398-01.jpg',
        'video' => ''
    ],
    [
        'title' => 'วัดมหาธาตุวรวิหาร',
        'title_en' => 'Wat Mahathat Worawihan',
        'category' => 'attraction',
        'district' => 'Mueang',
        'district_en' => 'Mueang',
        'content' => 'วัดคู่บ้านคู่เมือง มีพระปรางค์ 5 ยอดอันศักดิ์สิทธิ์',
        'content_en' => 'The principle temple of the city, featuring 5 sacred Prangs.',
        'image' => 'https://thailandtourismdirectory.go.th/assets/upload/2017/11/05/20171105c317565349e548234691461933096232152655.jpg',
        'video' => ''
    ],
    [
        'title' => 'วัดใหญ่สุวรรณาราม',
        'title_en' => 'Wat Yai Suwannaram',
        'category' => 'attraction',
        'district' => 'Mueang',
        'district_en' => 'Mueang',
        'content' => 'วัดที่มีศาลาการเปรียญไม้สักทองแกะสลักสมัยอยุธยา',
        'content_en' => 'A temple featuring an Ayutthaya-era carved golden teak sermon hall.',
        'image' => 'https://thai.tourismthailand.org/images/attraction/Attraction399-01.jpg',
        'video' => ''
    ],
    [
        'title' => 'วัดพระพุทธไสยาสน์ (วัดพระนอน)',
        'title_en' => 'Wat Phra Phuttha Saiyat (Reclining Buddha)',
        'category' => 'attraction',
        'district' => 'Mueang',
        'district_en' => 'Mueang',
        'content' => 'ประดิษฐานพระพุทธรูปปางไสยาสน์ที่มีขนาดใหญ่เป็นอันดับ 4 ของประเทศ',
        'content_en' => 'Housing the 4th largest Reclining Buddha image in Thailand.',
        'image' => 'https://thai.tourismthailand.org/images/attraction/Attraction401-01.jpg',
        'video' => ''
    ],
    [
        'title' => 'วัดเขาบันไดอิฐ',
        'title_en' => 'Wat Khao Bandai It',
        'category' => 'attraction',
        'district' => 'Mueang',
        'district_en' => 'Mueang',
        'content' => 'วัดเก่าแก่สมัยอยุธยา ตั้งอยู่บนไหล่เขา มีถ้ำสวยงามหลายแห่ง',
        'content_en' => 'An ancient Ayutthaya-era temple located on a hill slope, featuring several beautiful caves.',
        'image' => 'https://thailandtourismdirectory.go.th/assets/upload/2017/11/20/20171120023055ae8b9e4a3b0432363162791845184285.jpg',
        'video' => ''
    ],
    [
        'title' => 'พระธาตุฉิมพลีเศรษฐีนวโกฏิ วัดข่อย',
        'title_en' => 'Wat Khoi',
        'category' => 'attraction',
        'district' => 'Mueang',
        'district_en' => 'Mueang',
        'content' => 'สถาปัตยกรรมผสมผสานศิลปะชั้นสูง มีพระธาตุฉิมพลีเศรษฐีนวโกฏิที่งดงาม',
        'content_en' => 'Features mixed high-art architecture and the beautiful Phra That Chimphli Setthi Nawakot.',
        'image' => 'https://img.kapook.com/u/2017/surauch/Travel/jul/WatKhoi01.jpg',
        'video' => ''
    ],
    [
        'title' => 'วัดกำแพงแลง',
        'title_en' => 'Wat Kamphaeng Laeng',
        'category' => 'attraction',
        'district' => 'Mueang',
        'district_en' => 'Mueang',
        'content' => 'โบราณสถานปราสาทขอม 5 องค์ สร้างด้วยศิลาแลง',
        'content_en' => 'An ancient site with 5 Khmer-style laterite sanctuaries.',
        'image' => 'https://thai.tourismthailand.org/images/attraction/Attraction400-01.jpg',
        'video' => ''
    ],
    [
        'title' => 'พระจอมเกล้าฯ บรมราชานิทัศน์',
        'title_en' => 'King Mongkut Exhibition',
        'category' => 'attraction',
        'district' => 'Mueang',
        'district_en' => 'Mueang',
        'content' => 'พิพิธภัณฑ์จัดแสดงพระราชประวัติและพระราชกรณียกิจของรัชกาลที่ 4',
        'content_en' => 'Museum exhibiting the life and royal duties of King Rama IV.',
        'image' => 'https://via.placeholder.com/300x200?text=King+Mongkut+Exhibition',
        'video' => ''
    ],
    [
        'title' => 'ศูนย์การเรียนรู้วัฒนธรรมจังหวัดเพชรบุรี',
        'title_en' => 'Phetchaburi Cultural Learning Center',
        'category' => 'attraction',
        'district' => 'Mueang',
        'district_en' => 'Mueang',
        'content' => 'แหล่งเรียนรู้ศิลปวัฒนธรรมและภูมิปัญญาท้องถิ่นเมืองเพชร',
        'content_en' => 'A learning center for Phetchaburi arts, culture, and local wisdom.',
        'image' => 'https://via.placeholder.com/300x200?text=Cultural+Center',
        'video' => ''
    ],
    [
        'title' => 'หาดเจ้าสำราญ',
        'title_en' => 'Hat Chao Samran',
        'category' => 'attraction',
        'district' => 'Mueang',
        'district_en' => 'Mueang',
        'content' => 'ชายหาดประวัติศาสตร์ สถานที่พักผ่อนตากอากาศยอดนิยม',
        'content_en' => 'A historic beach and popular seaside resort destination.',
        'image' => 'https://thai.tourismthailand.org/images/attraction/Attraction392-01.jpg',
        'video' => ''
    ],

    // 2. Ban Laem
    [
        'title' => 'โครงการศึกษาวิจัยและพัฒนาสิ่งแวดล้อมแหลมผักเบี้ย',
        'title_en' => 'Laem Phak Bia Environmental Study Project',
        'category' => 'attraction',
        'district' => 'Ban Laem',
        'district_en' => 'Ban Laem',
        'content' => 'โครงการพระราชดำริฯ แหล่งศึกษาป่าชายเลนและบำบัดน้ำเสีย',
        'content_en' => 'Royal project ecosystem study center for mangroves and waste water treatment.',
        'image' => 'https://live.staticflickr.com/65535/51136427338_a572332b70_b.jpg',
        'video' => ''
    ],
    [
        'title' => 'ฟาร์มทะเลตัวอย่างในสมเด็จพระนางเจ้าสิริกิติ์',
        'title_en' => 'Queen Sirikit Model Sea Farm',
        'category' => 'attraction',
        'district' => 'Ban Laem',
        'district_en' => 'Ban Laem',
        'content' => 'แหล่งสาธิตการเลี้ยงสัตว์ทะเลและทำนาเกลือแบบผสมผสาน',
        'content_en' => 'Demonstration site for marine farming and integrated salt farming.',
        'image' => 'https://thai.tourismthailand.org/images/attraction/Attraction6017-01.jpg',
        'video' => ''
    ],
    [
        'title' => 'วัดในกลาง',
        'title_en' => 'Wat Nai Klang',
        'category' => 'attraction',
        'district' => 'Ban Laem',
        'district_en' => 'Ban Laem',
        'content' => 'วัดที่มีกุฎิเรือนไทยไม้สักทองทั้งหลัง',
        'content_en' => 'Temple with monk living quarters built entirely of golden teak.',
        'image' => 'https://f.ptcdn.info/436/047/000/ogq9q856q9yS7P7682-o.jpg',
        'video' => ''
    ],
    [
        'title' => 'วัดเขาตะเครา',
        'title_en' => 'Wat Khao Takhrao',
        'category' => 'attraction',
        'district' => 'Ban Laem',
        'district_en' => 'Ban Laem',
        'content' => 'ที่ประดิษฐานหลวงพ่อทอง พระพุทธรูปศักดิ์สิทธิ์คู่เมืองเพชร',
        'content_en' => 'Home to Luang Pho Thong, a highly revered Buddha image of Phetchaburi.',
        'image' => 'https://via.placeholder.com/300x200?text=Wat+Khao+Takhrao',
        'video' => ''
    ],
    [
        'title' => 'วัดต้นสน',
        'title_en' => 'Wat Ton Son',
        'category' => 'attraction',
        'district' => 'Ban Laem',
        'district_en' => 'Ban Laem',
        'content' => 'วัดสำคัญในอำเภอบ้านแหลม มีรูปปั้นสมเด็จพระเจ้าตากสินมหาราช',
        'content_en' => 'An important temple in Ban Laem, housing a statue of King Taksin the Great.',
        'image' => 'https://via.placeholder.com/300x200?text=Wat+Ton+Son',
        'video' => ''
    ],
    [
        'title' => 'จุดชมวิวสะพานเฉลิมพระเกียรติฯ บางตะบูน',
        'title_en' => 'Bang Tabun Viewpoint',
        'category' => 'attraction',
        'district' => 'Ban Laem',
        'district_en' => 'Ban Laem',
        'content' => 'จุดชมวิวปากแม่น้ำบางตะบูนและวิถีชีวิตชาวประมงพื้นบ้าน',
        'content_en' => 'Scenic viewpoint of the Bang Tabun estuary and local fishermen lifestyle.',
        'image' => 'https://via.placeholder.com/300x200?text=Bang+Tabun+Bridge',
        'video' => ''
    ],
    [
        'title' => 'เรือเภตรานิพพานัง',
        'title_en' => 'Petra Nipphanang Boat',
        'category' => 'attraction',
        'district' => 'Ban Laem',
        'district_en' => 'Ban Laem',
        'content' => 'อุโบสถทรงเรือสำเภาขนาดใหญ่ ณ วัดนอกปากทะเล',
        'content_en' => 'A large boat-shaped Ubosot at Wat Nok Pak Thale.',
        'image' => 'https://via.placeholder.com/300x200?text=Boat+Temple',
        'video' => ''
    ],
    [
        'title' => 'ธนาคารปูม้าแพปลาชุมชนแหลมผักเบี้ย',
        'title_en' => 'Blue Crab Bank',
        'category' => 'attraction',
        'district' => 'Ban Laem',
        'district_en' => 'Ban Laem',
        'content' => 'ศูนย์การเรียนรู้และอนุรักษ์พันธุ์ปูม้า',
        'content_en' => 'Learning center for the conservation of blue crabs.',
        'image' => 'https://via.placeholder.com/300x200?text=Crab+Bank',
        'video' => ''
    ],

    // 3. Khao Yoi
    [
        'title' => 'โบสถ์ไม้สักวัดกุฎิ',
        'title_en' => 'Wat Kuti Teak Chapel',
        'category' => 'attraction',
        'district' => 'Khao Yoi',
        'district_en' => 'Khao Yoi',
        'content' => 'โบสถ์ไม้สักแกะสลักลวดลายสวยงาม หาชมยาก',
        'content_en' => 'A rare and beautifully carved teak wood chapel.',
        'image' => 'https://via.placeholder.com/300x200?text=Wat+Kuti',
        'video' => ''
    ],
    [
        'title' => 'วัดเขาย้อยและถ้ำเขาย้อย',
        'title_en' => 'Wat Khao Yoi & Cave',
        'category' => 'attraction',
        'district' => 'Khao Yoi',
        'district_en' => 'Khao Yoi',
        'content' => 'วัดและถ้ำที่ประดิษฐานพระพุทธไสยาสน์และรอยพระพุทธบาท',
        'content_en' => 'Temple and cave housing a reclining Buddha and Buddha footprint.',
        'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/6/6e/Khao_Yoi_Cave_01.jpg/800px-Khao_Yoi_Cave_01.jpg',
        'video' => ''
    ],
    [
        'title' => 'ศูนย์วัฒนธรรมไทยทรงดำ(ลาวโซ่ง)',
        'title_en' => 'Thai Song Dam Cultural Center',
        'category' => 'attraction',
        'district' => 'Khao Yoi',
        'district_en' => 'Khao Yoi',
        'content' => 'แหล่งเรียนรู้วิถีชีวิต ประเพณี และวัฒนธรรมของชาวไทยทรงดำ',
        'content_en' => 'Learning center for the lifestyle, traditions, and culture of the Thai Song Dam people.',
        'image' => 'https://via.placeholder.com/300x200?text=Thai+Song+Dam',
        'video' => ''
    ],
    [
        'title' => 'พิพิธภัณฑ์ปานถนอม',
        'title_en' => 'Pan Thanom Museum',
        'category' => 'attraction',
        'district' => 'Khao Yoi',
        'district_en' => 'Khao Yoi',
        'content' => 'พิพิธภัณฑ์รวบรวมของเก่าและเรื่องราวในอดีตของชุมชน',
        'content_en' => 'Local museum collecting antiques and community history.',
        'image' => 'https://via.placeholder.com/300x200?text=Museum',
        'video' => ''
    ],
    [
        'title' => 'วัดพวงมาลัย - เขาอีโก้',
        'title_en' => 'Wat Phuang Malai - Khao I-Ko',
        'category' => 'attraction',
        'district' => 'Khao Yoi',
        'district_en' => 'Khao Yoi',
        'content' => 'สถานที่ท่องเที่ยวทางธรรมชาติและศาสนา',
        'content_en' => 'Nature and religious tourist attraction.',
        'image' => 'https://via.placeholder.com/300x200?text=Khao+I-Ko',
        'video' => ''
    ],
    [
        'title' => 'ถ้ำโบ้ บ้านคีรีวงษ์',
        'title_en' => 'Tham Bo',
        'category' => 'attraction',
        'district' => 'Khao Yoi',
        'district_en' => 'Khao Yoi',
        'content' => 'จุดถ่ายรูปช่องเขาที่มองเห็นวิวทุ่งนาสวยงาม',
        'content_en' => 'A photo spot with a mountain cave framing beautiful rice field views.',
        'image' => 'https://via.placeholder.com/300x200?text=Tham+Bo',
        'video' => ''
    ],

    // 4. Ban Lat
    [
        'title' => 'มิวเซียมเพชรบุรี',
        'title_en' => 'Museum Phetchaburi',
        'category' => 'attraction',
        'district' => 'Ban Lat',
        'district_en' => 'Ban Lat',
        'content' => 'แหล่งเรียนรู้ประวัติศาสตร์และศิลปวัฒนธรรมเมืองเพชร (ถ้ามีข้อมูลในบ้านลาด)',
        'content_en' => 'Learning center for history and culture.',
        'image' => 'https://via.placeholder.com/300x200?text=Museum+Phetchaburi',
        'video' => ''
    ],
    [
        'title' => 'วัดถ้ำรงค์',
        'title_en' => 'Wat Tham Rong',
        'category' => 'attraction',
        'district' => 'Ban Lat',
        'district_en' => 'Ban Lat',
        'content' => 'วัดเก่าแก่ที่มีหลวงพ่อดำ พระพุทธรูปศักดิ์สิทธิ์',
        'content_en' => 'Ancient temple housing the sacred Luang Pho Dam Buddha image.',
        'image' => 'https://via.placeholder.com/300x200?text=Wat+Tham+Rong',
        'video' => ''
    ],
    [
        'title' => 'สวนตาลลุงถนอม',
        'title_en' => 'Lung Thanom Toddy Palm Garden',
        'category' => 'attraction',
        'district' => 'Ban Lat',
        'district_en' => 'Ban Lat',
        'content' => 'สวนตาลโตนดแหล่งเรียนรู้ภูมิปัญญาการทำน้ำตาลสด',
        'content_en' => 'Toddy palm garden and learning center for making fresh palm sugar.',
        'image' => 'https://via.placeholder.com/300x200?text=Lung+Thanom',
        'video' => ''
    ],

    // 5. Tha Yang
    [
        'title' => 'โครงการชั่งหัวมันตามพระราชดำริ',
        'title_en' => 'Chang Hua Man Royal Project',
        'category' => 'attraction',
        'district' => 'Tha Yang',
        'district_en' => 'Tha Yang',
        'content' => 'โครงการทดลองด้านการเกษตรและแหล่งท่องเที่ยวเชิงเกษตรของในหลวง ร.9',
        'content_en' => 'Royal agricultural experiment project and agro-tourism site.',
        'image' => 'https://thai.tourismthailand.org/images/attraction/Attraction6017-01.jpg',
        'video' => ''
    ],
    [
        'title' => 'เขตห้ามล่าพันธุ์สัตว์ป่าเขากระปุก-เขาเตาหม้อ',
        'title_en' => 'Khao Kapuk - Khao Tao Mo Wildlife Sanctuary',
        'category' => 'attraction',
        'district' => 'Tha Yang',
        'district_en' => 'Tha Yang',
        'content' => 'พื้นที่อนุรักษ์ธรรมชาติและสัตว์ป่า',
        'content_en' => 'Nature and wildlife conservation area.',
        'image' => 'https://via.placeholder.com/300x200?text=Wildlife+Sanctuary',
        'video' => ''
    ],
    [
        'title' => 'ศูนย์เรียนรู้ทางการเกษตรเขากระปุกฯ',
        'title_en' => 'Khao Kapuk Agricultural Learning Center',
        'category' => 'attraction',
        'district' => 'Tha Yang',
        'district_en' => 'Tha Yang',
        'content' => 'ศูนย์การเรียนรู้ตามแนวพระราชดำริสมเด็จพระเทพฯ',
        'content_en' => 'Royal initiative agricultural learning center.',
        'image' => 'https://via.placeholder.com/300x200?text=Agri+Center',
        'video' => ''
    ],
    [
        'title' => 'วัดพระพุทธบาทเขาลูกช้าง',
        'title_en' => 'Wat Phra Phutthabat Khao Luk Chang',
        'category' => 'attraction',
        'district' => 'Tha Yang',
        'district_en' => 'Tha Yang',
        'content' => 'วัดที่มีรอยพระพุทธบาทและบรรยากาศเงียบสงบ',
        'content_en' => 'Temple housing a Buddha footprint in a peaceful setting.',
        'image' => 'https://via.placeholder.com/300x200?text=Wat+Khao+Luk+Chang',
        'video' => ''
    ],
    [
        'title' => 'บ่อตะกั่ว',
        'title_en' => 'Bo Takua',
        'category' => 'attraction',
        'district' => 'Tha Yang',
        'district_en' => 'Tha Yang',
        'content' => 'แหล่งท่องเที่ยวพักผ่อนหย่อนใจริมน้ำ',
        'content_en' => 'Lakeside recreation area.',
        'image' => 'https://via.placeholder.com/300x200?text=Bo+Takua',
        'video' => ''
    ],
    [
        'title' => 'เดอะฟิลด์ แอนนิมอล ดรีม',
        'title_en' => 'The Field Animals Dream',
        'category' => 'attraction',
        'district' => 'Tha Yang',
        'district_en' => 'Tha Yang',
        'content' => 'สวนสัตว์ขนาดเล็กและสถานที่พักผ่อนสำหรับครอบครัว',
        'content_en' => 'Mini zoo and family recreation spot.',
        'image' => 'https://via.placeholder.com/300x200?text=The+Field',
        'video' => ''
    ],
    [
        'title' => 'หาดปึกเตียน',
        'title_en' => 'Puek Tian Beach',
        'category' => 'attraction',
        'district' => 'Tha Yang',
        'district_en' => 'Tha Yang',
        'content' => 'ชายหาดที่มีรูปปั้นนางผีเสื้อสมุทรขนาดใหญ่',
        'content_en' => 'Beach featuring a large statue of Phi Suea Samut (Sea Giantess).',
        'image' => 'https://thai.tourismthailand.org/images/attraction/Attraction405-01.jpg',
        'video' => ''
    ],

    // 6. Cha-am
    [
        'title' => 'พระราชนิเวศน์มฤคทายวัน',
        'title_en' => 'Mrigadayavan Palace',
        'category' => 'attraction',
        'district' => 'Cha-am',
        'district_en' => 'Cha-am',
        'content' => 'พระราชวังแห่งความรักและความหวัง สร้างด้วยไม้สักทองริมทะเล',
        'content_en' => 'Palace of Love and Hope, built of golden teak by the sea.',
        'image' => 'https://thai.tourismthailand.org/images/attraction/Attraction387-01.jpg',
        'video' => ''
    ],
    [
        'title' => 'อุทยานสิ่งแวดล้อมนานาชาติสิรินธร',
        'title_en' => 'Sirindhorn International Environmental Park',
        'category' => 'attraction',
        'district' => 'Cha-am',
        'district_en' => 'Cha-am',
        'content' => 'ศูนย์เรียนรู้ด้านการอนุรักษ์พลังงานและสิ่งแวดล้อม',
        'content_en' => 'Learning center for energy and environmental conservation.',
        'image' => 'https://via.placeholder.com/300x200?text=Sirindhorn+Park',
        'video' => ''
    ],
    [
        'title' => 'สวนสมเด็จพระศรีนครินทราบรมราชชนนี',
        'title_en' => 'Somdet Phra Srinagarindra Park',
        'category' => 'attraction',
        'district' => 'Cha-am',
        'district_en' => 'Cha-am',
        'content' => 'สวนสาธารณะและโครงการเกษตรผสมผสาน',
        'content_en' => 'Public park and integrated agriculture project.',
        'image' => 'https://via.placeholder.com/300x200?text=Somdet+Park',
        'video' => ''
    ],
    [
        'title' => 'โครงการตามพระราชประสงค์หุบกะพง',
        'title_en' => 'Hub Kapong Royal Project',
        'category' => 'attraction',
        'district' => 'Cha-am',
        'district_en' => 'Cha-am',
        'content' => 'ศูนย์เรียนรู้การเกษตรแผนใหม่และการสหกรณ์',
        'content_en' => 'Learning center for modern agriculture and cooperatives.',
        'image' => 'https://via.placeholder.com/300x200?text=Hub+Kapong',
        'video' => ''
    ],
    [
        'title' => 'ศูนย์ศึกษาการพัฒนาห้วยทราย',
        'title_en' => 'Huai Sai Development Study Center',
        'category' => 'attraction',
        'district' => 'Cha-am',
        'district_en' => 'Cha-am',
        'content' => 'ศูนย์ศึกษาการฟื้นฟูป่าไม้และพัฒนาที่ดิน',
        'content_en' => 'Study center for forest rehabilitation and land development.',
        'image' => 'https://via.placeholder.com/300x200?text=Huai+Sai',
        'video' => ''
    ],
    [
        'title' => 'โครงการเครือข่ายอ่างเก็บน้ำ (อ่างพวง)',
        'title_en' => 'Ang Phuang Reservoir Network',
        'category' => 'attraction',
        'district' => 'Cha-am',
        'district_en' => 'Cha-am',
        'content' => 'โครงการบริหารจัดการน้ำตามแนวพระราชดำริ',
        'content_en' => 'Royal initiative water management project.',
        'image' => 'https://via.placeholder.com/300x200?text=Ang+Phuang',
        'video' => ''
    ],
    [
        'title' => 'วนอุทยานชะอํา',
        'title_en' => 'Cha-am Forest Park',
        'category' => 'attraction',
        'district' => 'Cha-am',
        'district_en' => 'Cha-am',
        'content' => 'พื้นที่ป่าไม้ร่มรื่นสำหรับพักผ่อนและออกกำลังกาย',
        'content_en' => 'Shady forest area for recreation and exercise.',
        'image' => 'https://via.placeholder.com/300x200?text=Cha-am+Park',
        'video' => ''
    ],
    [
        'title' => 'วนอุทยานเขานางพันธุรัต',
        'title_en' => 'Khao Nang Phanthurat Forest Park',
        'category' => 'attraction',
        'district' => 'Cha-am',
        'district_en' => 'Cha-am',
        'content' => 'ภูเขารูปร่างยักษ์พันธุรัต มีตำนานเล่าขานและเส้นทางศึกษาธรรมชาติ',
        'content_en' => 'Mountain shaped like the giantess Phanthurat, with legends and nature trails.',
        'image' => 'https://thailandtourismdirectory.go.th/assets/upload/2017/11/05/201711059f1396160175b94871d3780360a08688123225.jpg',
        'video' => ''
    ],
    [
        'title' => 'โบราณสถาน ทุ่งเศรษฐี',
        'title_en' => 'Thung Setthi Ancient Site',
        'category' => 'attraction',
        'district' => 'Cha-am',
        'district_en' => 'Cha-am',
        'content' => 'โบราณสถานเจดีย์เก่าแก่',
        'content_en' => 'Ancient pagoda site.',
        'image' => 'https://via.placeholder.com/300x200?text=Thung+Setthi',
        'video' => ''
    ],
    [
        'title' => 'พระบรมอนุเสาวรีย์สมเด็จพระนเรศวร',
        'title_en' => 'King Naresuan Monument',
        'category' => 'attraction',
        'district' => 'Cha-am',
        'district_en' => 'Cha-am',
        'content' => 'อนุสาวรีย์รำลึกถึงสมเด็จพระนเรศวรมหาราช',
        'content_en' => 'Monument honoring King Naresuan the Great.',
        'image' => 'https://via.placeholder.com/300x200?text=King+Naresuan',
        'video' => ''
    ],
    [
        'title' => 'ปูชักสะพานยก',
        'title_en' => 'Pu Chak Saphan Yok',
        'category' => 'attraction',
        'district' => 'Cha-am',
        'district_en' => 'Cha-am',
        'content' => 'วิถีชาวประมงคลองหินเหล็กไฟ ชักปูม้าสดๆ ขึ้นมาขาย',
        'content_en' => 'Fisherman lifestyle showcasing fresh blue crab catching.',
        'image' => 'https://via.placeholder.com/300x200?text=Pu+Chak',
        'video' => ''
    ],
    [
        'title' => 'ถ้ำค้างคาว',
        'title_en' => 'Bat Cave',
        'category' => 'attraction',
        'district' => 'Cha-am',
        'district_en' => 'Cha-am',
        'content' => 'ถ้ำธรรมชาติที่มีค้างคาวอาศัยอยู่จำนวนมาก',
        'content_en' => 'Natural cave inhabited by many bats.',
        'image' => 'https://via.placeholder.com/300x200?text=Bat+Cave',
        'video' => ''
    ],
    [
        'title' => 'วัดเนรัญชราราม',
        'title_en' => 'Wat Neranchararam',
        'category' => 'attraction',
        'district' => 'Cha-am',
        'district_en' => 'Cha-am',
        'content' => 'วัดที่มีพระพุทธรูปปิดทวารทั้ง 9 (พระปิดทวาร) ที่หาชมยาก',
        'content_en' => 'Temple housing a rare Buddha image covering all 9 orifices.',
        'image' => 'https://via.placeholder.com/300x200?text=Wat+Neranchararam',
        'video' => ''
    ],
    [
        'title' => 'วัดห้วยทรายใต้',
        'title_en' => 'Wat Huai Sai Tai',
        'category' => 'attraction',
        'district' => 'Cha-am',
        'district_en' => 'Cha-am',
        'content' => 'วัดที่มีวิหารหลวงพ่อทอง',
        'content_en' => 'Temple with Luang Pho Thong Vihara.',
        'image' => 'https://via.placeholder.com/300x200?text=Wat+Huai+Sai',
        'video' => ''
    ],
    [
        'title' => 'วัดนายาง',
        'title_en' => 'Wat Na Yang',
        'category' => 'attraction',
        'district' => 'Cha-am',
        'district_en' => 'Cha-am',
        'content' => 'วัดเก่าแก่ที่มีสถาปัตยกรรมไม้แกะสลักสวยงาม',
        'content_en' => 'Old temple with beautiful wood carvings.',
        'image' => 'https://via.placeholder.com/300x200?text=Wat+Na+Yang',
        'video' => ''
    ],
    [
        'title' => 'วัดชะอำ',
        'title_en' => 'Wat Cha-am',
        'category' => 'attraction',
        'district' => 'Cha-am',
        'district_en' => 'Cha-am',
        'content' => 'วัดคู่ชุมชนชะอำ มีถ้ำที่ประดิษฐานพระพุทธรูป',
        'content_en' => 'Community temple with a cave housing Buddha images.',
        'image' => 'https://via.placeholder.com/300x200?text=Wat+Cha-am',
        'video' => ''
    ],
    [
        'title' => 'หาดชะอำ',
        'title_en' => 'Cha-am Beach',
        'category' => 'attraction',
        'district' => 'Cha-am',
        'district_en' => 'Cha-am',
        'content' => 'ชายหาดท่องเที่ยวยอดนิยม มีกิจกรรมทางน้ำมากมาย',
        'content_en' => 'Popular tourist beach with many water activities.',
        'image' => 'https://thai.tourismthailand.org/images/attraction/Attraction386-01.jpg',
        'video' => ''
    ],
    [
        'title' => 'หาดบางเกตุ',
        'title_en' => 'Bang Ket Beach',
        'category' => 'attraction',
        'district' => 'Cha-am',
        'district_en' => 'Cha-am',
        'content' => 'ชายหาดเงียบสงบ เหมาะแก่การพักผ่อน',
        'content_en' => 'Peaceful beach suitable for relaxation.',
        'image' => 'https://via.placeholder.com/300x200?text=Bang+Ket',
        'video' => ''
    ],
    [
        'title' => 'พันธ์สุข ฟู้ด แอนด์ ฟาร์ม',
        'title_en' => '1000 Sook Food & Farm',
        'category' => 'attraction',
        'district' => 'Cha-am',
        'district_en' => 'Cha-am',
        'content' => 'ฟาร์มสไตล์ยุโรป ร้านอาหารและของฝาก',
        'content_en' => 'European style farm with restaurant and souvenir shop.',
        'image' => 'https://via.placeholder.com/300x200?text=1000+Sook',
        'video' => ''
    ],
    [
        'title' => 'มาลัยฟาร์ม',
        'title_en' => 'Malai Farm',
        'category' => 'attraction',
        'district' => 'Cha-am',
        'district_en' => 'Cha-am',
        'content' => 'ศูนย์เรียนรู้เชิงท่องเที่ยวด้านปศุสัตว์และสวนสัตว์ขนาดย่อม',
        'content_en' => 'Livestock learning center and mini zoo.',
        'image' => 'https://via.placeholder.com/300x200?text=Malai+Farm',
        'video' => ''
    ],
    [
        'title' => 'สวนอูฐ ชะอำ',
        'title_en' => 'Camel Republic',
        'category' => 'attraction',
        'district' => 'Cha-am',
        'district_en' => 'Cha-am',
        'content' => 'สวนสนุกและสวนสัตว์สไตล์โมร็อกโก',
        'content_en' => 'Moroccan style theme park and zoo.',
        'image' => 'https://thai.tourismthailand.org/images/attraction/Attraction6017-01.jpg',
        'video' => ''
    ],
    [
        'title' => 'เดอะ เวเนเซีย',
        'title_en' => 'The Venezia Hua Hin',
        'category' => 'attraction',
        'district' => 'Cha-am',
        'district_en' => 'Cha-am',
        'content' => 'แหล่งท่องเที่ยวช้อปปิ้งจำลองบรรยากาศเมืองเวนิส',
        'content_en' => 'Shopping attraction simulating Venice.',
        'image' => 'https://via.placeholder.com/300x200?text=Venezia',
        'video' => ''
    ],
    [
        'title' => 'ฟาร์มแกะ ชะอำ',
        'title_en' => 'Swiss Sheep Farm',
        'category' => 'attraction',
        'district' => 'Cha-am',
        'district_en' => 'Cha-am',
        'content' => 'ฟาร์มแกะบรรยากาศสวิสเซอร์แลนด์',
        'content_en' => 'Swiss-style sheep farm.',
        'image' => 'https://via.placeholder.com/300x200?text=Sheep+Farm',
        'video' => ''
    ],

    // 7. Nong Ya Plong
    [
        'title' => 'น้ำพุร้อนหนองหญ้าปล้อง',
        'title_en' => 'Nong Ya Plong Hot Spring',
        'category' => 'attraction',
        'district' => 'Nong Ya Plong',
        'district_en' => 'Nong Ya Plong',
        'content' => 'บ่อน้ำพุร้อนธรรมชาติและศูนย์บริการสุขภาพ',
        'content_en' => 'Natural hot spring and health center.',
        'image' => 'https://thailandtourismdirectory.go.th/assets/upload/2017/11/05/20171105c93116515431665f8386377651631557113149.jpg',
        'video' => ''
    ],
    [
        'title' => 'น้ำตกกวางโจว',
        'title_en' => 'Kwang Chow Waterfall Floating Market',
        'category' => 'attraction',
        'district' => 'Nong Ya Plong',
        'district_en' => 'Nong Ya Plong',
        'content' => 'ตลาดน้ำกลางป่าบรรยากาศร่มรื่น',
        'content_en' => 'Floating market in a forest setting.',
        'image' => 'https://ik.imagekit.io/tvlk/blog/2018/06/Kwang-Chow-Waterfall-Floating-Market-1.jpg',
        'video' => ''
    ],
    [
        'title' => 'วัดยางน้ำกลัดใต้',
        'title_en' => 'Wat Yang Nam Klat Tai',
        'category' => 'attraction',
        'district' => 'Nong Ya Plong',
        'district_en' => 'Nong Ya Plong',
        'content' => 'วัดที่มีพิพิธภัณฑ์พื้นบ้านไทยกะเหรี่ยง',
        'content_en' => 'Temple housing a Thai-Karen folk museum.',
        'image' => 'https://via.placeholder.com/300x200?text=Wat+Yang',
        'video' => ''
    ],
    [
        'title' => 'วัดวังพุไทร',
        'title_en' => 'Wat Wang Phu Sai',
        'category' => 'attraction',
        'district' => 'Nong Ya Plong',
        'district_en' => 'Nong Ya Plong',
        'content' => 'สถานปฏิบัติธรรมท่ามกลางธรรมชาติ',
        'content_en' => 'Meditation center amidst nature.',
        'image' => 'https://via.placeholder.com/300x200?text=Wat+Wang+Phu+Sai',
        'video' => ''
    ],
    [
        'title' => 'ไร่เพชรมาลัยกุล',
        'title_en' => 'Rai Phet Malaikul',
        'category' => 'attraction',
        'district' => 'Nong Ya Plong',
        'district_en' => 'Nong Ya Plong',
        'content' => 'แหล่งท่องเที่ยวเชิงเกษตร สวนผลไม้',
        'content_en' => 'Agro-tourism site and fruit orchard.',
        'image' => 'https://via.placeholder.com/300x200?text=Rai+Phet',
        'video' => ''
    ],

    // 8. Kaeng Krachan
    [
        'title' => 'เขื่อนแก่งกระจาน',
        'title_en' => 'Kaeng Krachan Dam',
        'category' => 'attraction',
        'district' => 'Kaeng Krachan',
        'district_en' => 'Kaeng Krachan',
        'content' => 'เขื่อนดินขนาดใหญ่ ทะเลสาบน้ำจืดเหนือเขื่อนสวยงาม',
        'content_en' => 'Large earthen dam with a beautiful freshwater lake.',
        'image' => 'https://thai.tourismthailand.org/images/attraction/Attraction407-01.jpg',
        'video' => ''
    ],
    [
        'title' => 'อุทยานแห่งชาติแก่งกระจาน',
        'title_en' => 'Kaeng Krachan National Park',
        'category' => 'attraction',
        'district' => 'Kaeng Krachan',
        'district_en' => 'Kaeng Krachan',
        'content' => 'อุทยานแห่งชาติที่ใหญ่ที่สุดในไทย มรดกโลกทางธรรมชาติ',
        'content_en' => 'Largest national park in Thailand, a UNESCO World Heritage Site.',
        'image' => 'https://via.placeholder.com/300x200?text=National+Park',
        'video' => ''
    ],
    [
        'title' => 'บ้านกร่าง - พะเนินทุ่ง',
        'title_en' => 'Ban Krang - Phanoen Thung',
        'category' => 'attraction',
        'district' => 'Kaeng Krachan',
        'district_en' => 'Kaeng Krachan',
        'content' => 'จุดชมผีเสื้อและทะเลหมอกกุยบุรี',
        'content_en' => 'Butterfly watching spot and sea of mist.',
        'image' => 'https://thai.tourismthailand.org/images/attraction/Attraction408-01.jpg',
        'video' => ''
    ],
    [
        'title' => 'ศูนย์เรียนรู้โครงการเศรษฐกิจพอเพียงบ้านน้ำทรัพย์',
        'title_en' => 'Ban Nam Sap Learning Center',
        'category' => 'attraction',
        'district' => 'Kaeng Krachan',
        'district_en' => 'Kaeng Krachan',
        'content' => 'หมู่บ้านเศรษฐกิจพอเพียงต้นแบบ',
        'content_en' => 'Model sufficiency economy village.',
        'image' => 'https://via.placeholder.com/300x200?text=Ban+Nam+Sap',
        'video' => ''
    ],
    [
        'title' => 'ศูนย์เรียนรู้เศรษฐกิจพอเพียง เรือนจำชั่วคราวเขากลิ้ง',
        'title_en' => 'Khao Kling Temporary Prison Learning Center',
        'category' => 'attraction',
        'district' => 'Kaeng Krachan',
        'district_en' => 'Kaeng Krachan',
        'content' => 'ศูนย์เรียนรู้การเกษตรและบ้านดิน',
        'content_en' => 'Agricultural learning center and earthen houses.',
        'image' => 'https://via.placeholder.com/300x200?text=Khao+Kling',
        'video' => ''
    ],
    [
        'title' => 'ชุมชนบ้านถ้ำเสือ/ธนาคารต้นไม้',
        'title_en' => 'Ban Tham Suea Tree Bank',
        'category' => 'attraction',
        'district' => 'Kaeng Krachan',
        'district_en' => 'Kaeng Krachan',
        'content' => 'โครงการธนาคารต้นไม้และการท่องเที่ยวชุมชน',
        'content_en' => 'Tree bank project and community tourism.',
        'image' => 'https://via.placeholder.com/300x200?text=Tree+Bank',
        'video' => ''
    ],
    [
        'title' => 'อุทยานศาสนาพระโพธิสัตว์กวนอิม',
        'title_en' => 'Guanyin Bodhisattva Religious Park',
        'category' => 'attraction',
        'district' => 'Kaeng Krachan',
        'district_en' => 'Kaeng Krachan',
        'content' => 'อุทยานศาสนาและรูปปั้นเจ้าแม่กวนอิมไม้แกะสลัก',
        'content_en' => 'Religious park featuring wooden carved Guanyin statue.',
        'image' => 'https://via.placeholder.com/300x200?text=Guanyin+Park',
        'video' => ''
    ]

];

$sql = "INSERT INTO posts (title, title_en, category, district, district_en, content, content_en, excerpt, excerpt_en, image, video) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $pdo->prepare($sql);

foreach ($contents as $c) {
    if (!isset($c['category'])) $c['category'] = 'learning';
    if (!isset($c['district'])) $c['district'] = 'Mueang'; // Default
    if (!isset($c['district_en'])) $c['district_en'] = 'Mueang'; // Default
    
    $excerpt = mb_substr(strip_tags($c['content']), 0, 150) . '...';
    $excerpt_en = mb_substr(strip_tags($c['content_en']), 0, 150) . '...';
    
    $stmt->execute([
        $c['title'],
        $c['title_en'],
        $c['category'],
        $c['district'],
        $c['district_en'],
        $c['content'],
        $c['content_en'],
        $excerpt,
        $excerpt_en,
        $c['image'],
        $c['video']
    ]);
    
    echo "Inserted: {$c['title']} ({$c['district']})<br>";
}

echo "<br>Done! Database upgraded and populated with Attractions.";
?>
