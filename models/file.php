<?php

namespace Models;

class File {
	private $file;

	private $file_path;
	private $file_name;
	private $temp_file_name;
	private $file_size;
	private $file_type;
	private $extensions;
	private $file_extension;
	private $upload_dir;
	private $temp_dir;
	private $upload_file_path;
	private $temp_file_path;

	private $webp_to_jpg_file;


	public function __construct($file) {
		$this->upload_dir = get_proj_root_dir() . get_uploads_dir();
		$this->temp_dir = $this->upload_dir . "temp/";

		if (!empty($file["name"])) {
			$this->file = $file;
			$this->file_path = $this->file["tmp_name"];
			$this->file_size = filesize($this->file_path);
			$this->extensions = [
				"image/jpeg" => ".jpg",
				"image/png" => ".png"
			];

			$file_info = finfo_open(FILEINFO_MIME_TYPE);
			$this->file_type = finfo_file($file_info, $this->file_path);

			$this->file_extension = $this->extensions[$this->file_type] ?? ".jpg";

			$this->temp_file_name = "temp_" . time() . $this->file_extension;
			$this->file_name = time() . $this->file_extension;

			$this->temp_file_path = $this->temp_dir . $this->temp_file_name;
			$this->upload_file_path = $this->upload_dir . $this->file_name;
		}
	}

	public function temp_store() {
		// Move uploaded file to destination.
		if (move_uploaded_file($this->file_path, $this->temp_file_path)) {
			return $this->temp_file_name;
		}
		return false;
	}

	/**
	 * Upload the footage, ie.
	 * move the file to a permanent storage directory.
	 *
	 * @return string|false The filename
	 */
	public function upload($temp_file = "") {
		// If there was errors after the initial temp file was added to uploads/temp/,
		// the $__FILES will be empty for the next submission.
		// So we need to use the hidden input and move the stored temp file to the uploads/
		// to properly upload the photo on a successful submission.
		if (!empty($temp_file)) {
			$temp_file_path = $this->temp_dir . $temp_file;
			$file_name = str_replace("temp_", "", $temp_file);
			$file_path = $this->upload_dir . $file_name;

			if (copy($temp_file_path, $file_path)) {
				if (file_exists($temp_file_path)) {
					self::delete($temp_file_path);
				}
				return $file_name;
			}
		}
		// Used when the $__FILES is being used for the upload.
		else {
			// Move uploaded file to destination.
			if (move_uploaded_file($this->file_path, $this->upload_file_path)) {
				if (file_exists($this->temp_file_path)) {
					unlink($this->temp_file_path);
				}
				return $this->file_name;
			}
		}
		return false;
	}
	public static function delete($photo) {
		unlink($photo);

		return true;
	}
}
