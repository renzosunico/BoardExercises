<?php
class AppException extends Exception{}
class RecordNotFoundException extends ValidationException{}
class ValidationException extends AppException{}
class PictureFormatException extends AppException{}
class FileNotFound extends AppException{}
