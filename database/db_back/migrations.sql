-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 02, 2018 at 06:32 AM
-- Server version: 5.7.17
-- PHP Version: 7.0.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kingfisher`
--

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_10_12_000000_create_users_table', 1),
('2014_10_12_100000_create_password_resets_table', 1),
('2016_05_30_065041_entrust_setup_tables', 1),
('2016_05_30_092137_create_storage_tables', 1),
('2016_06_01_031207_create_captcha_table', 1),
('2016_06_12_103252_create_supplier_table', 1),
('2016_06_15_021003_create_jobs_table', 1),
('2016_06_15_022732_create_failed_jobs_table', 1),
('2016_06_15_054939_create_logistics_table', 1),
('2016_06_16_034646_create_stores_table', 1),
('2016_06_17_075930_create_categories_table', 1),
('2016_06_22_020718_create_products_table', 1),
('2016_06_22_032230_create_products_sku_table', 1),
('2016_06_22_094515_create_assets_table', 1),
('2016_07_07_130343_create_purchases_table', 1),
('2016_07_08_065635_create_counters_table', 1),
('2016_07_14_115818_create_returned_table', 1),
('2016_07_21_143359_create_enter_warehouses_table', 1),
('2016_07_27_113133_create_change_warehouse_table', 1),
('2016_08_04_115422_create_order_table', 1),
('2016_08_11_143515_create_records_table', 1),
('2016_08_15_161612_create_payment_account_table', 1),
('2016_08_17_153646_create_payment_order_table', 1),
('2016_08_18_194404_create_receive_order_table', 1),
('2016_09_05_184226_create_refund_goods_order_table', 1),
('2016_09_19_093620_create_refund_money_order_table', 1),
('2016_09_26_150433_add_votes_to_users_table', 1),
('2016_09_26_151056_add_votes_to_stores_table', 1),
('2016_09_27_180452_add_votes_to_refund_money_order__table', 1),
('2016_10_11_100113_add_votes_to_logistics_table', 1),
('2016_10_11_165750_create_store_storage_logistics_table', 1),
('2016_10_13_114615_add_votes_to_order_table', 1),
('2016_10_14_101108_create_consignor_table', 1),
('2016_10_20_195507_add_express_order_table', 1),
('2016_10_21_184640_create_prompt_message_table', 1),
('2016_10_24_162931_create_china_cities_table', 1),
('2016_10_25_210431_add_cover_id_to_suppliers_table', 1),
('2016_10_26_143527_create_positive_energys_table', 1),
('2016_10_27_175642_add_to_suppliers_table', 1),
('2016_10_28_114300_add_to_purchases_table', 1),
('2016_10_28_184509_add_send_to_order_table', 1),
('2016_10_30_212840_add_pec_for_order_table', 1),
('2016_10_30_221951_add_sex_to_users_table', 1),
('2016_10_31_092345_add_content_to_positive_energys_table', 1),
('2016_10_31_133911_create_urlibs_tables', 1),
('2016_10_31_135424_create_exinsheets_tables', 1),
('2016_10_31_165535_create_synchronous_stock_record_table', 1),
('2016_10_31_215439_add_cover_id_to_users_table', 1),
('2016_11_01_185721_add_votes_to_synchronous_stock_record_table', 1),
('2016_11_15_161721_create_order_users_table', 1),
('2016_11_18_162443_add_address_to_order_users_table', 2),
('2016_11_24_190837_update_city__to_users_table', 2),
('2016_11_25_103545_add_pay_count_to_users_table', 2),
('2016_11_30_093602_add_township_to_order_table', 2),
('2016_12_07_170255_add_order_user_id_to_order_table', 2),
('2016_12_08_120252_add_tel_to_order_users_table', 2),
('2016_12_13_182024_add_split_status_to_order_table', 2),
('2016_12_13_224541_add_union_table', 2),
('2016_12_16_163535_refund_money_relation', 2),
('2016_12_19_172747_add_refund_status_to_order_sku_relation_table', 2),
('2016_12_20_142554_add_tax_rate_to_purchase_sku_relation_table', 2),
('2016_12_22_172133_add_user_id_sales_to_order_table', 2),
('2016_12_26_135330_update_order_users_to_membership_table', 2),
('2016_12_26_152357_add_vop_to_order_table', 2),
('2016_12_26_153236_add_vop_to_order_sku_relation_table', 2),
('2017_01_05_095132_add_received_to_receive_table', 2),
('2017_01_05_154649_add_department_to_users_table', 2),
('2017_01_05_171017_add_start_time_to_suppliers_table', 2),
('2017_01_09_191722_add_order_number_to_payment_order_table', 2),
('2017_01_11_141250_add_surcharge_to_purchases_table', 2),
('2017_02_10_182423_add_department_to_storage_sku_count_table', 3),
('2017_02_13_160729_add_department_to_returned_purchases_table', 3),
('2017_02_22_103150_add_relation_to_suppliers_table', 4),
('2017_06_06_144614_add_invoice_info_to_purchases_table', 5),
('2017_06_14_142812_add_random_id_to_suppliers_table', 6),
('2017_06_16_141617_create_material_libraries_table', 7),
('2017_06_20_093537_create_product_user_relation', 8),
('2017_06_22_094926_add_votes_to_material_libraries_table', 8),
('2017_06_23_100900_add_random_id_to_membership_table', 9),
('2017_06_27_100754_add_random_to_material_libraries_table', 10),
('2017_06_28_210052_add_product_type_to_products_table', 11),
('2017_06_29_133728_add_zc_quantity_to_products_sku_table', 12),
('2017_06_20_143840_add_stock_to_product_user_relation', 13),
('2017_06_20_180119_create_product_sku_relation', 13),
('2017_06_26_171408_add_status_to_product_user_relation', 13),
('2017_07_07_144908_add_image_type_to_material_libraries_table', 14),
('2017_07_12_120018_create_article_models_table', 15),
('2017_07_17_181804_add_products_to_saas_type_table', 16),
('2017_07_18_092959_add_article_source_to_article_models_table', 17),
('2017_07_18_172347_create_site_table', 18),
('2017_07_18_172832_add_site_type_to_article_models_table', 19),
('2017_07_20_160203_add_article_describe_to_article_models_table', 20),
('2017_07_18_184402_create_feedback_table', 21),
('2017_07_20_115634_add_type_to_users_table', 21),
('2017_07_21_095516_add_article_image_to_article_models_table', 22),
('2017_07_24_091552_add_user_id_to_site_table', 23),
('2017_07_26_101638_add_product_id_to_material_libraries_table', 24),
('2017_07_26_165411_add_cover_id_to_article_models_table', 25),
('2017_07_26_165953_add_target_id_to_material_libraries_table', 25),
('2017_07_27_172355_add_status_to_article_models_table', 26),
('2017_07_26_140731_create_cooperation_relation_table', 27),
('2017_07_27_090956_add_items_to_site_table', 27),
('2017_07_27_150125_create_site_record_table', 27),
('2017_07_27_165703_update_url_to_site_table', 27),
('2017_08_01_114632_add_video_length_to_material_libraries_table', 28),
('2017_08_02_180144_add_status_to_material_libraries_table', 29),
('2017_08_02_174422_update_url_to_site_record_table', 30),
('2017_08_04_141826_add_sales_number_products_table', 30),
('2017_08_16_160033_add_mime_to_assets_table', 31),
('2017_08_17_094540_add_excel_type_to_order_table', 32),
('2017_08_15_105725_create_distribution_table', 33),
('2017_08_18_152035_add_express_state_to_order', 33),
('2017_08_24_094824_add_user_id_to_product_sku_relation', 33),
('2017_08_29_162311_add_quantity_to_product_sku_relation', 34),
('2017_08_30_161717_create_file_records_table', 34),
('2017_09_01_155005_add_count_to_file_records_table', 35),
('2017_09_13_185818_create_receive_order_interim_table', 36),
('2017_09_14_172821_update_store_name_to_receive_order_interim_table', 37),
('2017_09_15_100248_create_purchases_interim_table', 38),
('2017_09_11_105602_add_company_type_to_distribution', 39),
('2017_09_11_170920_add_verify_status_to_users', 39),
('2017_09_12_170654_add_position_to_distribution', 39),
('2017_09_22_122737_add_category_to_site_record_table', 39),
('2017_09_27_175239_add_invoice_to_order_table', 39),
('2017_10_11_173358_create_take_stock', 40),
('2017_10_11_173912_create_take_stock_detailed', 40),
('2017_10_13_151500_add_take_stock_id_take_stock_detailed', 40),
('2017_10_24_162456_update_outside_target_id_to_order_table', 40),
('2017_10_26_143514_add_unique_number_to_products_sku_table', 41),
('2017_11_09_185142_create_supplier_month_table', 42),
('2017_11_16_164330_create_micro_users_table', 43),
('2017_11_17_112456_change_price_at_to_product_user_relation', 44),
('2017_11_21_105957_add_from_type_to_order_table', 44),
('2017_11_20_175921_create_user_product', 45),
('2017_11_21_144103_create_cart_table', 45),
('2017_11_23_101132_create_delivery_address_table', 46),
('2017_11_27_102247_add_channel_id_to_order_sku_relation_table', 47),
('2017_11_30_164739_create_pays_table', 48),
('2017_12_13_134514_update_uid_to_pays_table', 49),
('2017_12_14_214032_create_order_mould_table', 50),
('2017_12_22_114246_add_mould_id_to_users_table', 51),
('2018_01_04_102805_create_sku_distributors_table', 52),
('2018_01_04_155821_add_mould_id_to_suppliers', 53),
('2018_01_07_153413_add_order_no_to_order_moulds', 53),
('2018_01_09_162047_add_sku_name_to_sku_distributors_table', 54),
('2018_01_10_115156_add_index_to_order', 55),
('2018_01_10_185153_add_user_id_sales_index_to_order', 55),
('2018_01_10_192929_add_order_id_index_to_order', 56),
('2018_01_11_135049_add_summary_to_file_records_table', 56),
('2018_01_11_154433_add_product_unopened_to_file_records_table', 57),
('2018_01_15_103337_create_tem_distribution_order', 58),
('2018_01_16_173526_add_distributor_price_to_order_sku_relation_table', 59),
('2018_01_26_104710_add_trademark_id_to_suppliers_table', 60),
('2018_01_30_175114_add_authorization_deadline_to_suppliers_table', 61),
('2018_02_02_124844_update_legal_person_to_suppliers_table', 62),
('2018_03_21_112512_update_mode_to_products_sku_table', 63),


