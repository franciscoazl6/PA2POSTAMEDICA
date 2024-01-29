import 'package:get/get.dart';

class MainController extends GetxController{
  void goToInfoPage() {
    Get.toNamed('/info');
  }
  void goToDataPage() {
    Get.toNamed('/data');
  }
  void goToChatPage() {
    Get.toNamed('/chat');
  }
  void goToDatePage() {
    Get.toNamed('/date');
  }
}