<?php
/*
RODRIGO
 */
require_once('class/uploadFoto.php');
class CustomUploadHandler extends UploadHandler {
	
    protected $error_messages = array(
        1 => 'O arquivo excede o upload_max_filesize definido no php.ini',
        2 => 'O arquivo excede o MAX_FILE_SIZE definido no formulário HTML',
        3 => 'O arquivo foi uploaded apenas parcialmente',
        4 => 'Nenhum arquivo enviado',
        6 => 'Pasta temporária não encontrada',
        7 => 'Falha ao escrever arquivo no disco',
        8 => 'Uma extensão PHP parou o file upload',
        'post_max_size' => 'O arquivo excede o post_max_size definido no php.ini',
        'max_file_size' => 'O arquivo é muito grande',
        'min_file_size' => 'O arquivo é muito pequeno',
        'accept_file_types' => 'Tipo de arquivo não permitido',
        'max_number_of_files' => 'Número máximo de arquivos excedido',
        'max_width' => 'Imagem acima da largura máxima',
        'min_width' => 'Imagem abaixo da largura mínima',
        'max_height' => 'Imagem acima da altura máxima',
        'min_height' => 'Imagem abaixo da altura mínima',
        'abort' => 'Upload do arquivo abortado',
        'image_resize' => 'Falha ao redimensionar a imagem'
    );

	protected function trim_file_name($file_path, $name, $size, $type, $error, $index, $content_range) {
		global $nome;
		$name = $nome.'-'.rand(1,99).'-'.date('his');
		$name = str_replace('.', '', $name);
		return $name;
	}

	protected function get_scaled_image_file_paths($file_name, $version) {
		global $nome;
		global $s;
		$tipo_post = $this->options['tipo_post'];
		$id = uploadFoto::getIdFotos($file_name,$tipo_post);
        $file_path = $this->get_upload_path($file_name);
        if (!empty($version)) {
            $version_dir = $this->get_upload_path(null, $version);
            if (!is_dir($version_dir)) {
                mkdir($version_dir, $this->options['mkdir_mode'], true);
            }

            switch (strtolower(pathinfo($file_path, PATHINFO_EXTENSION))) {
                case 'jpeg':
                case 'jpg':
                    $file_type = 'jpg';
                    break;
                case 'png':
                    $file_type = 'png';
                    break;
                case 'gif':
                    $file_type = 'gif';
                    break;
            }
			$file_name = $nome.'-'.rand(1,99).'-'.$version.'-'.date('his').'.'.$file_type;
			if($version=='thumb')uploadFoto::updateFotos($id,$tipo_post,$file_name,'it');
			if($version=='carrinho')uploadFoto::updateFotos($id,$tipo_post,$file_name,'itc');
			if($version=='home')uploadFoto::updateFotos($id,$tipo_post,$file_name,'ith');
			if($version=='interno')uploadFoto::updateFotos($id,$tipo_post,$file_name,'iti');
			if($version=='miniatura')uploadFoto::updateFotos($id,$tipo_post,$file_name,'itm');
			if($version=='relacionado')uploadFoto::updateFotos($id,$tipo_post,$file_name,'itr');
			if($version=='ultimos')uploadFoto::updateFotos($id,$tipo_post,$file_name,'itu');

            $new_file_path = $version_dir.'/'.$file_name;
        } else {
            $new_file_path = $file_path;
        }
        return array($file_path, $new_file_path);
    }

    protected function set_additional_file_properties($file) {
		global $s;
		$tipo_post = $this->options['tipo_post'];
		$id = uploadFoto::getIdFotos($file->name,$tipo_post);
        //$file->deleteUrl = $this->options['script_url'].$this->get_query_separator($this->options['script_url']).$this->get_singular_param_name().'='.rawurlencode($file->name);//?file= 
        $file->id = $id;//?file= 
        $file->deleteUrl = $this->options['script_url'].'/'.$id;//?file= 
        $file->deleteType = $this->options['delete_type'];
        if ($file->deleteType !== 'DELETE') {
            $file->deleteUrl .= '&_method=DELETE';
        }
        if ($this->options['access_control_allow_credentials']) {
            $file->deleteWithCredentials = true;
        }
    }

    protected function get_file_objects($iteration_method = 'get_file_object') {
		global $s;
		$tipo_post = $this->options['tipo_post'];
        $upload_dir = $this->get_upload_path();
        if (!is_dir($upload_dir)) {
            return array();
        }
		$fotos = uploadFoto::getFotos($s->id,$tipo_post);
        return array_values(array_filter(array_map(
            array($this, $iteration_method),
            //scandir($upload_dir)//PEGA AS FOTOS DA PASTA
			$fotos//PEGA AS FOTOS DO BANCO
        )));
    }

    protected function handle_file_upload($uploaded_file, $name, $size, $type, $error, $index = null, $content_range = null) {
		$tipo_post = $this->options['tipo_post'];
		global $s;
        $file = new \stdClass();
        $file->name = $this->get_file_name($uploaded_file, $name, $size, $type, $error,
            $index, $content_range);
        $file->size = $this->fix_integer_overflow((int)$size);
        $file->type = $type;
        if ($this->validate($uploaded_file, $file, $error, $index)) {
            $this->handle_form_data($file, $index);
            $upload_dir = $this->get_upload_path();
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, $this->options['mkdir_mode'], true);
            }
            $file_path = $this->get_upload_path($file->name);
            $append_file = $content_range && is_file($file_path) &&
                $file->size > $this->get_file_size($file_path);
            if ($uploaded_file && is_uploaded_file($uploaded_file)) {
                // multipart/formdata uploads (POST method uploads)
                if ($append_file) {
                    file_put_contents(
                        $file_path,
                        fopen($uploaded_file, 'r'),
                        FILE_APPEND
                    );
                } else {
                    move_uploaded_file($uploaded_file, $file_path);
					uploadFoto::insertFotos($s->id,$tipo_post,$file->name);
                }
            } else {
                // Non-multipart uploads (PUT method support)
                file_put_contents(
                    $file_path,
                    fopen($this->options['input_stream'], 'r'),
                    $append_file ? FILE_APPEND : 0
                );
            }
            $file_size = $this->get_file_size($file_path, $append_file);
            if ($file_size === $file->size) {
                $file->url = $this->get_download_url($file->name);
                if ($this->is_valid_image_file($file_path)) {
                    $this->handle_image_file($file_path, $file);
                }
            } else {
                $file->size = $file_size;
                if (!$content_range && $this->options['discard_aborted_uploads']) {
                    unlink($file_path);
                    $file->error = $this->get_error_message('abort');
                }
            }
            $this->set_additional_file_properties($file);
        }
        return $file;
    }

    public function delete($print_response = true) {
		global $s;
		$tipo_post = $this->options['tipo_post'];
		$P = $this->options['upload_dir'];
		$Pt = $this->options['image_versions']['thumb']['upload_dir'];
        $file_names = $this->get_file_names_params();
        if (empty($file_names)) {
            $file_names = array($this->get_file_name_param());
        }
        $response = array();
        foreach ($file_names as $file_name) {
            $file_path = $this->get_upload_path($file_name);
            $success = is_file($file_path) && $file_name[0] !== '.' && unlink($file_path);
            if ($success) {
                foreach ($this->options['image_versions'] as $version => $options) {
                    if (!empty($version)) {
                        $file = $this->get_upload_path($file_name, $version);
                        if (is_file($file)) {
                            unlink($file);
                        }
                    }
                }
            }
			uploadFoto::deleteFotos($s->id,$tipo_post,$P,$Pt);
            $response[$file_name] = $success;
        }
        return $this->generate_response($response, $print_response);
    }
}