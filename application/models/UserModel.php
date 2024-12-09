<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class UserModel extends CI_Model
{
   public function get_roles()
   {
      $this->db->order_by('role_id', 'asc');
      $query = $this->db->get('a_role')->result();
      return $query;
   }

   public function get_menu()
   {
      $this->db->order_by('menu_id', 'asc');
      $query = $this->db->get('a_menu')->result();
      return $query;
   }

   public function Max_data($mdate, $key, $table)
   {
      $this->db->select_max($key);
      $this->db->like($key, $mdate);
      $query = $this->db->get($table);
      return $query;
   }

   public function Input_Data($data, $table)
   {
      $this->db->insert($table, $data);
   }

   public function get($nik)
   {
      $this->db->where('username', $nik);
      $result = $this->db->get('a_user_system')->row();
      return $result;
   }

   public function get_role_info($nik)
   {
      $this->db->select('a_user_system.role_id, a_role.role_name');
      $this->db->from('a_user_system');
      $this->db->join('a_role', 'a_user_system.role_id = a_role.role_id');
      $this->db->where('a_user_system.username', $nik);
      $query = $this->db->get()->row();
      return $query;
   }

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

   public function get_by_id($id_user)
   {
      $this->db->from('a_user_system');
      $this->db->where('id_user', $id_user);
      $query = $this->db->get();

      if ($query->num_rows() > 0) {
         return $query->row(); // Mengembalikan satu baris sebagai objek
      } else {
         return null;
      }
   }
   // public function getroleid($nik)
   // {
   //    $this->db->select("a_user_system.role_id, a_role.role_name");
   //    $this->db->from('a_user_system');
   //    $this->db->join('a_role', 'a_user_system.role_id = a_role.role_id', 'inner');
   //    $this->db->where('a_user_system.username', $nik);
   //    $query = $this->db->get()->row();
   //    return $query;
   // }



   // public function get_hak_access($roleid, $menu_id)
   // {
   //    $this->db->select('allow_add, allow_edit, allow_delete');
   //    $this->db->from('a_role_access');
   //    $this->db->where('role_id', $roleid);
   //    $this->db->where('menu_id', $menu_id);
   //    $query = $this->db->get()->row();
   //    return $query;
   // }

   // public function get_controller_access($roleid, $controller)
   // {
   //    $this->db->select('a_menu.controller', 'a_menu.menu_name');
   //    $this->db->from('a_menu');
   //    $this->db->join('a_role_access', 'a_menu.menu_id = a_role_access.menu_id');
   //    $this->db->where('a_menu.controller', $controller);
   //    $this->db->where('a_role_access.role_id', $roleid);
   //    $query = $this->db->get();
   //    if ($query->num_rows() > 0) {
   //       return (object) array('found' => 'found');
   //    } else {
   //       return (object) array('found' => 'not found');
   //    }
   // }

   // public function get_menu_access($roleid)
   // {
   //    $this->db->select('a_menu.*, a_role_access.role_id');
   //    $this->db->from('a_menu');
   //    $this->db->join('a_role_access', 'a_menu.menu_id = a_role_access.menu_id');
   //    $this->db->where('a_role_access.role_id', $roleid);
   //    $this->db->where('a_menu.parentid', '1.0');
   //    $this->db->where('a_menu.controller', 'C_');
   //    $this->db->order_by('a_menu.menu_id', 'ASC');
   //    $query = $this->db->get()->result();
   //    return $query;
   // }

   // public function get_sub_menu($roleid)
   // {
   //    $this->db->select('a_menu.*', 'a_role_access.role_id');
   //    $this->db->from('a_menu');
   //    $this->db->join('a_role_access', 'a_menu.menu_id = a_role_access.menu_id');
   //    $this->db->where('a_role_access.role_id', $roleid);
   //    $this->db->where('a_menu.controller !=', 'C_');
   //    $this->db->order_by('a_menu.menu_id', 'ASC');
   //    $query = $this->db->get()->result();
   //    return $query;
   // }
}
