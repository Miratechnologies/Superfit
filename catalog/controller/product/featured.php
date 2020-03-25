<?php
if ($data['products']) {
	//added
	
	if (isset($this->request->get['page'])) {
			 $page = $this->request->get['page'];

		  } else {
			 $page = 1;
		  }

		  $this->data['pagination'] = '';
		  if (isset($this->request->get['product_id'])) {      
			 $pagination = new Pagination();
			 $pagination->total = sizeof($this->data['products']);
			 $pagination->page = $page;
			 $pagination->limit = $this->config->get('config_catalog_limit');
			 $pagination->text = $this->language->get('text_pagination');
			 $pagination->url = $this->url->link('module/featured', 'product_id=' . $this->request->get['product_id'] . '&page={page}');

			 $this->data['pagination'] = $pagination->render();
		  }
	
	
	//added end
	if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/featured.tpl')) {
		return $this->load->view($this->config->get('config_template') . '/template/module/featured.tpl', $data);
	} else {
		return $this->load->view('default/template/module/featured.tpl', $data);
	}
}
?>