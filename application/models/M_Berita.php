<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class M_Berita extends CI_Model
{
   public function get_tables_where($tables, $cari, $where, $iswhere)
   {
      $search = htmlspecialchars($this->input->post('search')['value']);
      $limit = preg_replace("/[^a-zA-Z0-9.]/", '', $this->input->post('length'));
      $start = preg_replace("/[^a-zA-Z0-9.]/", '', $this->input->post('start'));
      $order_field = $this->input->post('order')[0]['column'];
      $order_ascdesc = $this->input->post('order')[0]['dir'];
      $order = $this->input->post('columns')[$order_field]['data'] . " " . $order_ascdesc;

      $this->db->start_cache();
      $this->db->from($tables);

      foreach ($where as $key => $value) {
         $this->db->where($key, $value);
      }

      if (!empty($iswhere)) {
         $this->db->where($iswhere);
      }

      $this->db->stop_cache();
      $sql_count = $this->db->count_all_results();

      if (!empty($search)) {
         $this->db->group_start();
         foreach ($cari as $column) {
            $this->db->or_like($column, $search);
         }
         $this->db->group_end();
      }

      $this->db->order_by($order);
      $this->db->limit($limit, $start);
      $sql_data = $this->db->get();
      $data = $sql_data->result_array();

      if (!empty($search)) {
         $this->db->group_start();
         foreach ($cari as $column) {
            $this->db->or_like($column, $search);
         }
         $this->db->group_end();
         $sql_filter_count = $this->db->count_all_results();
      } else {
         $sql_filter_count = $sql_count;
      }

      $this->db->flush_cache();

      $callback = array(
         'draw' => $this->input->post('draw'),
         'recordsTotal' => $sql_count,
         'recordsFiltered' => $sql_filter_count,
         'data' => $data
      );

      return json_encode($callback);
   }

   public function Max_data($mdate, $key, $table)
   {
      $this->db->select_max($key);
      $this->db->like($key, $mdate);
      $query = $this->db->get($table);
      return $query;
   }

   function Input_Data($data, $table)
   {
      $this->db->insert($table, $data);
   }

   function Update_Data($where, $data, $table)
   {
      $this->db->where($where);
      $this->db->update($table, $data);
   }
   function Delete_Data($where, $table)
   {
      $this->db->where($where);
      $this->db->delete($table);
   }
   function ajax_getbyhdrid($common, $key, $table)
   {
      return $this->db->get_where($table, array($common => $key));
   }

   public function get_berita()
   {
      $this->db->from('tb_berita');
      $query = $this->db->get();
      return $query->result();
   }

   public function get_by_id($id_berita)
   {
      $this->db->from('tb_berita');
      $this->db->where('id_berita', $id_berita);
      $query = $this->db->get();

      if ($query->num_rows() > 0) {
         return $query->row(); // Mengembalikan satu baris sebagai objek
      } else {
         return null;
      }
   }
}
